<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mission;
use App\Models\MissionScene;
use App\Models\MissionChoice;
use App\Models\UserMission;
use App\Models\UserReward;
use App\Models\Relic;
use App\Models\UserRelic;
use App\Models\Achievement;
use App\Models\UserAchievement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MissionEngineController extends Controller
{
    // ─── GET /api/engine/missions ─────────────────────────────
    // Returns mission card data for the frontend grid — no auth needed
    public function getMissions()
    {
        $missionsData = include database_path('seeders/MissionsData.php');

        $dbMissions = Mission::all()->keyBy('title');

        $result = [];
        foreach ($missionsData as $m) {
            $dbMission = $dbMissions[$m['title']] ?? null;
            if ($dbMission) {
                $m['db_id'] = $dbMission->id;
            }

            if (isset($m['image'])) {
                $m['image'] = asset(str_replace(' ', '%20', $m['image']));
            }
            if (isset($m['bgm'])) {
                $m['bgm'] = asset(str_replace(' ', '%20', $m['bgm']));
            }

            unset($m['nodes']);
            $result[] = $m;
        }

        return response()->json($result);
    }

    // ─── GET /api/engine/history ─────────────────────────────────
    public function getHistory()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Not authenticated'], 401);
        }

        $history = \App\Models\UserMission::with('mission')
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->orderBy('updated_at', 'desc')
            ->take(12)
            ->get()
            ->map(function ($hm) {
                // Determine scene to get rewards if we wanted them, but we might not have scene easily
                $scene = \App\Models\MissionScene::find($hm->current_scene_id);
                $rewards = $scene ? ($scene->rewards ?? []) : [];
                if (is_string($rewards)) {
                    $rewards = json_decode($rewards, true) ?? [];
                }
                
                return [
                    'title' => $hm->mission->title ?? 'Unknown Mission',
                    'time' => $hm->updated_at->format('n/j/Y, g:i:s A'),
                    'outcome' => 'completed',
                    'rewards' => $rewards
                ];
            });

        return response()->json($history);
    }

    // ─── GET /api/engine/missions/{id}/load ───────────────────
    // Loads a mission. Works for guests AND logged-in users.
    // Guests always get the start scene.
    // Logged-in users resume their saved progress (or start fresh).
    public function loadMission(Request $request, $missionId)
    {
        $mission = $this->findMission($missionId);
        if (!$mission) {
            return response()->json(['error' => 'Mission not found'], 404);
        }

        $user = Auth::user();

        // If user is logged in, persist progress; otherwise just serve the start scene
        if ($user) {
            $userMission = UserMission::where('user_id', $user->id)
                ->where('mission_id', $mission->id)
                ->first();

            $needsRestart = !$userMission
                || $userMission->status === 'completed'
                || !$userMission->current_scene_id;

            if ($needsRestart) {
                $startScene = $this->findStartScene($mission->id);
                if (!$startScene) {
                    return response()->json(['error' => 'No start scene found for this mission'], 500);
                }

                $userMission = UserMission::updateOrCreate(
                    ['user_id' => $user->id, 'mission_id' => $mission->id],
                    ['status' => 'in_progress', 'current_scene_id' => $startScene->id, 'reward_claimed' => false]
                );
            }

            $scene = MissionScene::with('choices')->find($userMission->current_scene_id);
        } else {
            // Guest: always serve the start scene, no DB write
            $scene = $this->findStartScene($mission->id);
            if ($scene) {
                $scene->load('choices');
            }
        }

        if (!$scene) {
            return response()->json(['error' => 'Scene not found'], 500);
        }

        return response()->json($this->formatSceneResponse($scene, $mission));
    }

    // ─── POST /api/engine/missions/{id}/choice ────────────────
    // Makes a choice. Works for guests AND logged-in users.
    // Client sends the current scene_id so we can validate without DB (for guests).
    public function makeChoice(Request $request, $missionId)
    {
        $mission = $this->findMission($missionId);
        if (!$mission) {
            return response()->json(['error' => 'Mission not found'], 404);
        }

        $choiceId = $request->input('choice_id');
        $choice   = MissionChoice::find($choiceId);

        if (!$choice) {
            return response()->json(['error' => 'Choice not found'], 404);
        }

        $user = Auth::user();

        if ($user) {
            // Logged-in: validate against the user's saved current scene
            $userMission = UserMission::where('user_id', $user->id)
                ->where('mission_id', $mission->id)
                ->first();

            if (!$userMission) {
                // Auto-create if missing (e.g. fresh session)
                $startScene = $this->findStartScene($mission->id);
                $userMission = UserMission::create([
                    'user_id'          => $user->id,
                    'mission_id'       => $mission->id,
                    'status'           => 'in_progress',
                    'current_scene_id' => $startScene?->id,
                    'reward_claimed'   => false,
                ]);
            }

            if ($userMission->status === 'completed') {
                // Allow replaying
                $startScene = $this->findStartScene($mission->id);
                $userMission->update([
                    'status'           => 'in_progress',
                    'current_scene_id' => $startScene?->id,
                    'reward_claimed'   => false,
                ]);
            }

            // For logged-in users, validate the choice belongs to their current scene
           
            $clientSceneId = $request->input('current_scene_id');
            $validScene = $choice->scene_id === $userMission->current_scene_id
                       || ($clientSceneId && $choice->scene_id === $clientSceneId);

            if (!$validScene) {
                return response()->json([
                    'error'    => 'Invalid choice for current scene',
                    'expected' => $userMission->current_scene_id,
                    'choice_scene' => $choice->scene_id,
                ], 400);
            }

            $nextScene = MissionScene::with('choices')->find($choice->next_scene_id);
            if (!$nextScene) {
                return response()->json(['error' => 'Next scene not found'], 500);
            }

            $userMission->update(['current_scene_id' => $nextScene->id]);

        } else {
            // Guest: just look up the next scene directly. No DB state.
            $nextScene = MissionScene::with('choices')->find($choice->next_scene_id);
            if (!$nextScene) {
                return response()->json(['error' => 'Next scene not found'], 500);
            }
        }

        $data = $this->formatSceneResponse($nextScene, $mission);
        $data['consequence_text'] = $choice->consequence_text;

        return response()->json($data);
    }

    // ─── POST /api/engine/missions/{id}/claim ─────────────────
    // Claims reward — only for logged-in users
    public function claimReward(Request $request, $missionId)
    {
        $user = Auth::user();
        if (!$user) {
            // Return success silently for guests so the UI still shows the reward panel
            return response()->json([
                'success' => true,
                'message' => 'Log in to save your rewards permanently!',
                'rewards' => [],
            ]);
        }

        $mission = $this->findMission($missionId);
        if (!$mission) {
            return response()->json(['error' => 'Mission not found'], 404);
        }

        $userMission = UserMission::where('user_id', $user->id)
            ->where('mission_id', $mission->id)
            ->first();

        if (!$userMission) {
            return response()->json(['error' => 'Mission not active'], 400);
        }

        $scene = MissionScene::find($userMission->current_scene_id);

        if (!$scene || !$scene->is_ending) {
            return response()->json(['error' => 'Not at an ending scene'], 400);
        }

        if ($userMission->reward_claimed) {
            return response()->json(['message' => 'Reward already claimed', 'rewards' => $scene->rewards]);
        }

        $rewards  = $scene->rewards ?? [];
        
        if (is_string($rewards)) {
            $rewards = json_decode($rewards, true) ?? [];
        }
        
        $goldGain = 0;
        $repGain  = 0;
        $relicNames = [];

        if (is_array($rewards)) {
            foreach ($rewards as $r) {
                $lower = strtolower($r);
                if (str_contains($lower, 'gold')) {
                    $goldGain += abs((int) filter_var($r, FILTER_SANITIZE_NUMBER_INT));
                } elseif (str_contains($lower, 'reputation')) {
                    $val = (int) filter_var($r, FILTER_SANITIZE_NUMBER_INT);
                    $repGain += str_contains($r, '-') ? -$val : $val;
                } elseif (str_contains($lower, 'relic')) {
                    // Extract the relic name from reward strings like "1 Relic: Aztec Coin" or "Aztec Coin Relic"
                    $relicNames[] = $r;
                }
            }
        }

        // Update gold & reputation
        $userReward = UserReward::firstOrCreate(['user_id' => $user->id]);
        $userReward->update([
            'gold'       => $userReward->gold + $goldGain,
            'reputation' => $userReward->reputation + $repGain,
        ]);

        $grantedRelics = [];
        // Award relics — try to match relic names to the relics table
        foreach ($relicNames as $rewardText) {
            // Look for an exact or partial match of relic name in the reward string
            $allRelics = Relic::all();
            $matched = null;
            foreach ($allRelics as $relic) {
                if (stripos($rewardText, $relic->name) !== false) {
                    $matched = $relic;
                    break;
                }
            }

            // If no named match, pick a random relic not yet owned by user
            if (!$matched) {
                $ownedIds = UserRelic::where('user_id', $user->id)->pluck('relic_id')->toArray();
                $matched = Relic::whereNotIn('id', $ownedIds)->inRandomOrder()->first();
            }

            if ($matched) {
                $alreadyOwned = UserRelic::where('user_id', $user->id)
                    ->where('relic_id', $matched->id)
                    ->exists();
                if (!$alreadyOwned) {
                    UserRelic::create([
                        'user_id'       => $user->id,
                        'relic_id'      => $matched->id,
                        'acquired_date' => now(),
                    ]);
                }
                $grantedRelics[] = $matched;
            }
        }

        $userMission->update(['status' => 'completed', 'reward_claimed' => true]);

        // Check & unlock any newly earned achievements
        $unlockedAchievements = $this->checkAndGrantAchievements($user);

        return response()->json([
            'success' => true,
            'rewards' => $rewards,
            'gained' => [
                'gold' => $goldGain,
                'reputation' => $repGain,
                'relics' => $grantedRelics,
                'achievements' => $unlockedAchievements
            ],
            'message' => 'Rewards successfully claimed!',
        ]);
    }

    // ─── Achievement checker ──────────────────────────────────

    private function checkAndGrantAchievements($user): array
    {
        $unlockedAchievements = [];
        $completedMissions = UserMission::where('user_id', $user->id)
            ->where('status', 'completed')->count();

        $userReward = UserReward::where('user_id', $user->id)->first();
        $totalGold  = $userReward ? $userReward->gold : 0;

        $relicCount = UserRelic::where('user_id', $user->id)->count();

        $already = UserAchievement::where('user_id', $user->id)
            ->pluck('achievement_id')->toArray();

        $all = Achievement::all();
        foreach ($all as $achievement) {
            if (in_array($achievement->id, $already)) {
                continue; // already unlocked
            }

            $unlocked = false;
            switch ($achievement->condition_type) {
                case 'missions_completed':
                    $unlocked = $completedMissions >= $achievement->condition_value;
                    break;
                case 'gold_earned':
                    $unlocked = $totalGold >= $achievement->condition_value;
                    break;
                case 'relics_collected':
                    $unlocked = $relicCount >= $achievement->condition_value;
                    break;
            }

            if ($unlocked) {
                UserAchievement::create([
                    'user_id'        => $user->id,
                    'achievement_id' => $achievement->id,
                    'unlocked_at'    => now(),
                ]);
                $unlockedAchievements[] = $achievement;
            }
        }
        
        return $unlockedAchievements;
    }

    // ─── Private helpers ──────────────────────────────────────

    private function findMission($missionId): ?Mission
    {
        if (is_numeric($missionId)) {
            return Mission::find($missionId);
        }

        // Last-resort: find by scene prefix
        $scene = MissionScene::where('id', 'like', $missionId . '-%')->first();
        return $scene?->mission;
    }

    private function findStartScene(int $missionId): ?MissionScene
    {
        return MissionScene::where('mission_id', $missionId)
            ->where('id', 'like', '%-start')
            ->first()
            ?? MissionScene::where('mission_id', $missionId)
                ->orderBy('id')
                ->first();
    }

    private function formatSceneResponse(MissionScene $scene, Mission $mission): array
    {
        if (!$scene->relationLoaded('choices')) {
            $scene->load('choices');
        }

        $choices = $scene->choices->map(function ($c) {
            return [
                'id'          => $c->id,
                'label'       => $c->choice_text,
                'consequence' => $c->consequence_text,
                'sfx'         => $c->sfx ? asset(str_replace(' ', '%20', $c->sfx)) : null,
            ];
        })->values();

        return [
            'mission_id'    => $mission->id,
            'mission_title' => $mission->title,
            'scene_id'      => $scene->id,
            'title'         => $scene->title,
            'text'          => $scene->scene_text,
            'image'         => $scene->image ? asset(str_replace(' ', '%20', $scene->image)) : null,
            'is_ending'     => (bool) $scene->is_ending,
            'outcome'       => $scene->outcome_type,
            'rewards'       => $scene->rewards,
            'choices'       => $choices,
        ];
    }
}
