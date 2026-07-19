<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TavernPost;
use App\Models\TavernComment;
use App\Models\TavernRumor;
use App\Models\TavernLike;
use App\Models\UserReward;
use App\Models\PirateProfile;
use Illuminate\Support\Facades\Auth;

class TavernController extends Controller
{
    /**
     * Get all tavern posts with their author, likes, and reply counts.
     */
    public function getPosts()
    {
        $posts = TavernPost::with(['user.pirateProfile', 'comments.user.pirateProfile'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($post) {
                // Determine avatar from profile, fallback to a themed default
                $avatar = $post->user->avatar_url;
                if (!$avatar) {
                    $avatars = ['avatar-01-skull.png', 'avatar-02-captain.png', 'avatar-03-compass.png', 'avatar-04-flag.png', 'avatar-05-anchor.png', 'avatar-06-swords.png'];
                    $avatar = 'assets/images/tavern/avatars/' . $avatars[array_rand($avatars)];
                } else if (!filter_var($avatar, FILTER_VALIDATE_URL)) {
                    $avatar = 'assets/images/avatars/' . $avatar;
                }
                
                return [
                    'id' => $post->id,
                    'title' => $post->title,
                    'message' => $post->content,
                    'author' => $post->user->pirateProfile->pirate_name ?? $post->user->name,
                    'avatar' => url($avatar),
                    'time' => $post->created_at->diffForHumans(),
                    'replies' => $post->comments->count(),
                    'likes' => $post->likes_count,
                    'has_liked' => Auth::check() ? $post->likes()->where('user_id', Auth::id())->exists() : false,
                    'comments_data' => $post->comments->map(function ($comment) {
                        $cAvatar = $comment->user->avatar_url;
                        if (!$cAvatar) {
                            $cAvatar = 'assets/images/tavern/avatars/avatar-02-captain.png';
                        } else if (!filter_var($cAvatar, FILTER_VALIDATE_URL)) {
                            $cAvatar = 'assets/images/avatars/' . $cAvatar;
                        }
                        return [
                            'id' => $comment->id,
                            'author' => $comment->user->pirateProfile->pirate_name ?? $comment->user->name,
                            'avatar' => url($cAvatar),
                            'message' => $comment->content,
                            'time' => $comment->created_at->diffForHumans()
                        ];
                    })
                ];
            });

        return response()->json($posts);
    }

    /**
     * Create a new post.
     */
    public function createPost(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'content' => 'required|string|max:500'
        ]);

        if (!Auth::check()) {
            return response()->json(['error' => 'You must be logged in to post.'], 401);
        }

        $post = TavernPost::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content
        ]);

        // Reward the user for contributing
        $this->updateReputation(Auth::id(), 5);

        return response()->json(['success' => true, 'post' => $post]);
    }

    /**
     * Create a comment on a post.
     */
    public function createComment(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:300'
        ]);

        if (!Auth::check()) {
            return response()->json(['error' => 'You must be logged in to reply.'], 401);
        }

        $post = TavernPost::findOrFail($id);

        $comment = TavernComment::create([
            'tavern_post_id' => $post->id,
            'user_id' => Auth::id(),
            'content' => $request->content
        ]);

        $this->updateReputation(Auth::id(), 2);

        return response()->json(['success' => true, 'comment' => $comment]);
    }

    /**
     * Toggle like on a post.
     */
    public function toggleLike(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'You must be logged in to like.'], 401);
        }

        $post = TavernPost::findOrFail($id);
        $userId = Auth::id();

        $existingLike = TavernLike::where('tavern_post_id', $post->id)
                                  ->where('user_id', $userId)
                                  ->first();

        if ($existingLike) {
            $existingLike->delete();
            $post->decrement('likes_count');
            $action = 'unliked';
        } else {
            TavernLike::create([
                'tavern_post_id' => $post->id,
                'user_id' => $userId
            ]);
            $post->increment('likes_count');
            $action = 'liked';
            $this->updateReputation($userId, 1);
        }

        return response()->json(['success' => true, 'action' => $action, 'likes' => $post->likes_count]);
    }

    /**
     * Get active rumors.
     */
    public function getRumors()
    {
        $rumors = TavernRumor::where('is_active', true)
                             ->orderBy('created_at', 'desc')
                             ->limit(10)
                             ->get()
                             ->map(function ($rumor) {
                                 // Add random icons like the hardcoded ones
                                 $icons = ['👻', '💎', '🏴‍☠️', '🌊', '⚰️', '⚓', '⚔️'];
                                 return [
                                     'id' => $rumor->id,
                                     'text' => $rumor->content,
                                     'source' => $rumor->source,
                                     'icon' => $icons[array_rand($icons)]
                                 ];
                             });

        // Fallback to defaults if DB is empty
        if ($rumors->isEmpty()) {
            $rumors = collect([
                ['text' => '"A ghost ship seen near Tortuga... The Black Pearl sails again!"', 'source' => '— Mysterious Sailor', 'icon' => '👻'],
                ['text' => '"Treasure discovered in cursed caves. Fortune awaits the brave."', 'source' => '— Captain Stormcaller', 'icon' => '💎'],
                ['text' => '"Barbossa recruiting crew for a daring heist. No cowards need apply."', 'source' => '— Port Tavern Notice', 'icon' => '🏴‍☠️'],
            ]);
        }

        return response()->json($rumors);
    }

    /**
     * Get wanted notices.
     */
    public function getNotices()
    {
        $notices = \App\Models\TavernNotice::orderBy('created_at', 'desc')
                                           ->limit(5)
                                           ->get();

        // Fallback to defaults if DB is empty
        if ($notices->isEmpty()) {
            $notices = collect([
                ['id' => 1, 'name' => 'Captain Black Tide', 'reward' => '500 Gold Pieces', 'desc' => 'Dangerous pirate. Wanted for piracy and theft. Approach with caution.', 'image' => 'wanted-captain-black-tide.jpg'],
                ['id' => 2, 'name' => 'The Kraken', 'reward' => '1000 Gold Pieces', 'desc' => 'Mythical sea beast. Extremely dangerous. Glory awaits the brave hunter.', 'image' => 'wanted-kraken.jpg'],
            ]);
        }

        return response()->json($notices);
    }

    /**
     * Get the leaderboard.
     */
    public function getLeaderboard()
    {
        $topPirates = UserReward::with('user.pirateProfile', 'user.missions')
            ->orderBy('reputation', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($reward, $index) {
                $rankNum = $index + 1;
                $medal = '';
                if ($rankNum === 1) $medal = '🥇 ';
                if ($rankNum === 2) $medal = '🥈 ';
                if ($rankNum === 3) $medal = '🥉 ';

                $avatar = $reward->user->avatar_url;
                if (!$avatar) {
                    $avatars = ['avatar-07-chest.png', 'avatar-08-kraken.png', 'avatar-09-hook.png', 'avatar-10-cannonball.png', 'avatar-11-bearded.png', 'avatar-12-eye-patch.png'];
                    $avatar = 'assets/images/tavern/avatars/' . $avatars[array_rand($avatars)];
                } else if (!filter_var($avatar, FILTER_VALIDATE_URL)) {
                    $avatar = 'assets/images/avatars/' . $avatar;
                }
                $avatar = url($avatar);

                $name = $reward->user->pirateProfile->pirate_name ?? $reward->user->name;
                
                // Calculate star rating based on reputation (approximate logic)
                $stars = str_repeat('⭐', min(5, max(1, ceil($reward->reputation / 20))));
                
                // Get missions count
                $missionsCount = $reward->user->missions()->where('status', 'completed')->count();
                
                // Get relics count
                $relicsCount = is_array($reward->relics) ? count($reward->relics) : 0;

                return [
                    'rank' => $medal . $rankNum,
                    'avatar' => $avatar,
                    'name' => $name,
                    'rep' => $stars . ' ' . number_format($reward->reputation),
                    'missions' => $missionsCount,
                    'relics' => $relicsCount,
                    'class' => $rankNum <= 5 ? 'rank-' . $rankNum : ''
                ];
            });

        return response()->json($topPirates);
    }

    /**
     * Buy a drink at the tavern.
     */
    public function buyDrink(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'You must be logged in to buy drinks.'], 401);
        }

        $request->validate([
            'drink_name' => 'required|string',
            'price' => 'required|integer|min:0'
        ]);

        $userId = Auth::id();
        $reward = UserReward::firstOrCreate(
            ['user_id' => $userId],
            ['gold' => 0, 'reputation' => 0, 'relics' => []]
        );

        if ($reward->gold < $request->price) {
            return response()->json(['error' => 'Not enough gold! You need ' . $request->price . ' coins.'], 400);
        }

        $reward->decrement('gold', $request->price);
        
        // Give a little reputation for spending money at the tavern
        $this->updateReputation($userId, 1);

        return response()->json([
            'success' => true, 
            'message' => 'You bought ' . $request->drink_name . '!',
            'new_gold' => $reward->fresh()->gold
        ]);
    }

    /**
     * Helper method to update reputation and recalculate rank.
     */
    private function updateReputation($userId, $amount)
    {
        $reward = UserReward::firstOrCreate(
            ['user_id' => $userId],
            ['gold' => 0, 'reputation' => 0, 'relics' => []]
        );

        $reward->increment('reputation', $amount);

        // Recalculate rank
        $profile = PirateProfile::where('user_id', $userId)->first();
        if ($profile) {
            $rep = $reward->fresh()->reputation;
            $newRank = 'Deckhand';
            
            if ($rep >= 100) $newRank = 'Pirate Lord';
            elseif ($rep >= 50) $newRank = 'Captain';
            elseif ($rep >= 20) $newRank = 'Sailor';

            if ($profile->rank !== $newRank) {
                $profile->update(['rank' => $newRank]);
            }
        }
    }
}
