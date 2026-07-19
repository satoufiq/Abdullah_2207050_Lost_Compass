<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HallOfLegendsController extends Controller
{
    /**
     * Get the dynamic leaderboard.
     */
    public function getLeaderboard(Request $request)
    {
        $category = $request->query('category', 'all');

        $query = DB::table('users')
            ->leftJoin('user_rewards', 'users.id', '=', 'user_rewards.user_id')
            ->leftJoin('user_missions', function ($join) {
                $join->on('users.id', '=', 'user_missions.user_id')
                     ->where('user_missions.status', '=', 'completed');
            })
            ->leftJoin('user_relics', 'users.id', '=', 'user_relics.user_id')
            ->leftJoin('user_achievements', 'users.id', '=', 'user_achievements.user_id')
            ->select(
                'users.id',
                'users.pirate_name as name',
                'users.rank as title',
                'users.avatar as emblem',
                'users.ship as flagship',
                'users.allegiance',
                DB::raw('COALESCE(MAX(user_rewards.reputation), 0) as reputation'),
                DB::raw('COALESCE(MAX(user_rewards.gold), 0) as gold'),
                DB::raw('COUNT(DISTINCT user_missions.id) as missions'),
                DB::raw('COUNT(DISTINCT user_relics.id) as relics'),
                DB::raw('COUNT(DISTINCT user_achievements.id) as achievements'),
                DB::raw('(COALESCE(MAX(user_rewards.reputation), 0) * 2 + COUNT(DISTINCT user_missions.id) * 10 + COUNT(DISTINCT user_relics.id) * 15 + COUNT(DISTINCT user_achievements.id) * 20) as score')
            )
            ->whereNotNull('users.pirate_name')
            ->groupBy(
                'users.id',
                'users.pirate_name',
                'users.rank',
                'users.avatar',
                'users.ship',
                'users.allegiance'
            );

        // Sorting based on category
        switch ($category) {
            case 'reputation':
                $query->orderBy('reputation', 'desc');
                break;
            case 'missions':
                $query->orderBy('missions', 'desc');
                break;
            case 'relics':
                $query->orderBy('relics', 'desc');
                break;
            case 'gold':
                $query->orderBy('gold', 'desc');
                break;
            case 'all':
            default:
                $query->orderBy('score', 'desc');
                break;
        }

        $captains = $query->limit(100)->get();

        // Format data to match JS frontend expectations
        $formatted = $captains->map(function ($captain) {
            // Default emblem if none exists
            $emblem = $captain->emblem ?: 'assets/images/profile/emblems/skull-crossbones.png';
            if (!str_starts_with($emblem, 'assets') && !str_starts_with($emblem, 'http')) {
                // Adjust if it's just a filename
                $emblem = 'assets/images/profile/avatars/' . $emblem;
            }

            return [
                'id' => 'user-' . $captain->id,
                'user_id' => $captain->id,
                'name' => $captain->name ?: 'Unknown Pirate',
                'title' => $captain->title ?: 'Deckhand',
                'emblem' => $emblem,
                'flagship' => $captain->flagship ?: 'No Ship',
                'reputation' => (int) $captain->reputation,
                'missions' => (int) $captain->missions,
                'relics' => (int) $captain->relics,
                'gold' => (int) $captain->gold,
                'score' => (int) $captain->score,
                'allegiance' => $captain->allegiance ?: 'Independent',
                'motto' => 'The sea holds no prisoners.', // Default motto
                'bio' => 'A fearless sailor carving their name into the legends of the ocean.',
            ];
        });

        return response()->json($formatted);
    }

    /**
     * Get the logged-in user's rank.
     */
    public function getUserRank(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Not authenticated'], 401);
        }

        $userId = Auth::id();

        // Subquery to get scores
        $scoresQuery = DB::table('users')
            ->leftJoin('user_rewards', 'users.id', '=', 'user_rewards.user_id')
            ->leftJoin('user_missions', function ($join) {
                $join->on('users.id', '=', 'user_missions.user_id')
                     ->where('user_missions.status', '=', 'completed');
            })
            ->leftJoin('user_relics', 'users.id', '=', 'user_relics.user_id')
            ->leftJoin('user_achievements', 'users.id', '=', 'user_achievements.user_id')
            ->select(
                'users.id',
                DB::raw('COALESCE(MAX(user_rewards.reputation), 0) as reputation'),
                DB::raw('COALESCE(MAX(user_rewards.gold), 0) as gold'),
                DB::raw('COUNT(DISTINCT user_relics.id) as relics'),
                DB::raw('(COALESCE(MAX(user_rewards.reputation), 0) * 2 + COUNT(DISTINCT user_missions.id) * 10 + COUNT(DISTINCT user_relics.id) * 15 + COUNT(DISTINCT user_achievements.id) * 20) as score')
            )
            ->whereNotNull('users.pirate_name')
            ->groupBy('users.id');

        $allScores = $scoresQuery->get()->sortByDesc('score')->values();

        $userRankIndex = $allScores->search(function ($item) use ($userId) {
            return $item->id == $userId;
        });

        $userScoreData = $userRankIndex !== false ? $allScores[$userRankIndex] : null;
        $rank = $userRankIndex !== false ? $userRankIndex + 1 : '-';
        $score = $userScoreData ? (int) $userScoreData->score : 0;
        $reputation = $userScoreData ? (int) $userScoreData->reputation : 0;
        $relics = $userScoreData ? (int) $userScoreData->relics : 0;
        $gold = $userScoreData ? (int) $userScoreData->gold : 0;

        $pointsNeeded = 0;
        $nextRankPoints = 0;
        if ($userRankIndex !== false && $userRankIndex > 0) {
            $nextRankData = $allScores[$userRankIndex - 1];
            $nextRankPoints = (int) $nextRankData->score;
            $pointsNeeded = $nextRankPoints - $score;
        }

        return response()->json([
            'rank' => $rank,
            'score' => $score,
            'reputation' => $reputation,
            'relics' => $relics,
            'gold' => $gold,
            'points_needed' => $pointsNeeded,
            'next_rank_points' => $nextRankPoints,
        ]);
    }

    /**
     * Get global statistics.
     */
    public function getStatistics(Request $request)
    {
        $totalUsers = DB::table('users')->whereNotNull('pirate_name')->count();
        $totalMissions = DB::table('user_missions')->where('status', 'completed')->count();
        $totalRelics = DB::table('user_relics')->count();
        $totalGold = DB::table('user_rewards')->sum('gold');

        return response()->json([
            'total_users' => $totalUsers,
            'total_missions' => $totalMissions,
            'total_relics' => $totalRelics,
            'total_gold' => (int) $totalGold
        ]);
    }

    /**
     * Get Hall of Fame achievements.
     */
    public function getHallOfFame(Request $request)
    {
        $krakenSlayer = DB::table('users')
            ->join('user_achievements', 'users.id', '=', 'user_achievements.user_id')
            ->join('achievements', 'user_achievements.achievement_id', '=', 'achievements.id')
            ->where('achievements.title', 'like', '%Kraken%')
            ->select('users.pirate_name')
            ->first();

        // fallback to NPCs if no actual users have it
        return response()->json([
            [
                'id' => 'kraken-slayer',
                'title' => 'Kraken Slayer',
                'description' => 'Defeated the legendary beast of the deep and survived to tell the tale.',
                'holder' => $krakenSlayer ? $krakenSlayer->pirate_name : 'Jack Sparrow',
                'medal_class' => 'gold-medal',
                'icon' => '🦑'
            ],
            [
                'id' => 'master-navigator',
                'title' => 'Master Navigator',
                'description' => 'Mapped every cursed reef, hidden cove, and trade route across the Seven Seas.',
                'holder' => 'Captain Stormcaller',
                'medal_class' => 'silver-medal',
                'icon' => '🧭'
            ],
            [
                'id' => 'ghost-ship',
                'title' => 'Ghost Ship Survivor',
                'description' => 'Escaped the spectral clutches of the Flying Dutchman under full moon curse.',
                'holder' => 'Davy Jones',
                'medal_class' => 'bronze-medal',
                'icon' => '👻'
            ],
            [
                'id' => 'duelist',
                'title' => 'Legendary Duelist',
                'description' => 'Won 50 consecutive cutlass duels in the Tortuga Arena without taking a scratch.',
                'holder' => 'Hector Barbossa',
                'medal_class' => 'gold-medal',
                'icon' => '⚔️'
            ]
        ]);
    }
}
