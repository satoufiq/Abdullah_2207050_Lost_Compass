<?php

namespace App\Services;

use App\Models\User;
use App\Models\Achievement;
use App\Models\UserAchievement;

class AchievementService
{
    /**
     * Check and unlock achievements for a user.
     *
     * @param User $user
     * @return array Array of newly unlocked achievements
     */
    public function checkAchievements(User $user)
    {
        $newUnlocks = [];
        
        // Example logic: get user stats
        $missionsCompleted = $user->userMissions()->where('status', 'completed')->count();
        $totalReputation = $user->rewards()->sum('reputation');
        $relicsFound = $user->userRelics()->count();

        // Get all achievements
        $achievements = Achievement::all();

        // Get already unlocked achievements
        $unlockedIds = $user->userAchievements()->pluck('achievement_id')->toArray();

        foreach ($achievements as $achievement) {
            if (in_array($achievement->id, $unlockedIds)) {
                continue; // Already unlocked
            }

            $unlocked = false;

            switch ($achievement->condition_type) {
                case 'missions_completed':
                    if ($missionsCompleted >= $achievement->condition_value) {
                        $unlocked = true;
                    }
                    break;
                case 'reputation_gained':
                    if ($totalReputation >= $achievement->condition_value) {
                        $unlocked = true;
                    }
                    break;
                case 'relics_found':
                    if ($relicsFound >= $achievement->condition_value) {
                        $unlocked = true;
                    }
                    break;
            }

            if ($unlocked) {
                UserAchievement::create([
                    'user_id' => $user->id,
                    'achievement_id' => $achievement->id,
                ]);
                
                $newUnlocks[] = $achievement;
            }
        }

        return $newUnlocks;
    }
}
