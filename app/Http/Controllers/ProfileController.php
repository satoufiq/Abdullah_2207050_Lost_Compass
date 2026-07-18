<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the pirate profile.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $profile = $user->pirateProfile;
        
        $rank = $user->rank ?? 'Deckhand';
        if (($user->infamy_level ?? 0) > 10) $rank = 'Swashbuckler';
        if (($user->infamy_level ?? 0) > 50) $rank = 'Captain';
        
        $totalRelics = \App\Models\Relic::count();
        $relicsCollected = $user->userRelics()->count() ?? 0;
        
        $stats = [
            'missions_completed' => $user->userMissions()->where('status', 'completed')->count() ?? 0,
            'gold_earned' => $user->rewards()->sum('gold') ?? 0,
            'relics_collected' => $relicsCollected,
            'reputation' => $user->infamy_level ?? 0,
            'total_relics' => $totalRelics,
            'relic_progress' => $totalRelics > 0 ? round(($relicsCollected / $totalRelics) * 100) : 0,
            'legendary_relics' => $user->userRelics()->whereHas('relic', function($q) { $q->where('rarity', 'Legendary'); })->count(),
            'epic_relics' => $user->userRelics()->whereHas('relic', function($q) { $q->where('rarity', 'Epic'); })->count(),
            'rare_relics' => $user->userRelics()->whereHas('relic', function($q) { $q->where('rarity', 'Rare'); })->count(),
            'common_relics' => $user->userRelics()->whereHas('relic', function($q) { $q->where('rarity', 'Common'); })->count(),
        ];
        
        $shipName = $user->ship ?? 'No Ship Claimed';
        $ship = \App\Models\Ship::where('name', $shipName)->first();
        
        $weapon = $user->weapon ?? 'Bare Hands';
        $weaponImage = null;
        if ($weapon !== 'Bare Hands') {
            $wc = strtolower(str_replace([' ', "'"], ['-', ''], $weapon));
            $weaponImage = "weapon-{$wc}.png";
        }
        
        $relicsQuery = \App\Models\Relic::query();
        if ($request->filled('search')) {
            $relicsQuery->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('rarity') && $request->rarity !== 'all') {
            $relicsQuery->where('rarity', $request->rarity);
        }
        
        $allRelics = $relicsQuery->get();
        $categories = collect();
        $ownedRelicIds = $user->userRelics()->pluck('relic_id')->toArray();
        $missionHistory = $user->userMissions()->with('mission')->orderBy('updated_at', 'desc')->get();
        $userAchievements = \App\Models\UserAchievement::with('achievement')->where('user_id', $user->id)->get();
        $availableChests = max(0, $stats['missions_completed'] - $stats['relics_collected']);

        return view('pages.profile', compact(
            'user', 'profile', 'rank', 'stats', 'shipName', 'ship', 'weapon', 'weaponImage', 'allRelics', 'categories', 'ownedRelicIds', 'missionHistory', 'userAchievements', 'availableChests'
        ));
    }

    /**
     * Fetch details of a specific relic for the modal.
     */
    public function relicDetails($id)
    {
        $relic = \App\Models\Relic::findOrFail($id);
        return response()->json([
            'relic_name' => $relic->name,
            'origin' => $relic->origin_location,
            'movie' => $relic->movie_reference,
            'power' => $relic->power_description,
            'description' => $relic->description,
            'rarity' => $relic->rarity,
            'category' => ucfirst($relic->rarity),
            'image' => $relic->image
        ]);
    }

    /**
     * Open a treasure chest to unlock a random relic.
     */
    public function openChest(Request $request)
    {
        $user = $request->user();
        
        $missionsCompleted = $user->userMissions()->where('status', 'completed')->count() ?? 0;
        $relicsCollected = $user->userRelics()->count() ?? 0;
        $availableChests = max(0, $missionsCompleted - $relicsCollected);
        
        if ($availableChests <= 0) {
            return response()->json(['success' => false, 'error' => 'You have no unopened chests. Complete more missions to earn chests!']);
        }

        $ownedIds = $user->userRelics()->pluck('relic_id')->toArray();
        $availableRelics = \App\Models\Relic::whereNotIn('id', $ownedIds)->get();
        
        if ($availableRelics->isEmpty()) {
            return response()->json(['success' => false, 'error' => 'You have collected all relics!']);
        }
        
        $randomRelic = $availableRelics->random();
        
        \App\Models\UserRelic::create([
            'user_id' => $user->id,
            'relic_id' => $randomRelic->id
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Chest opened successfully!',
            'reward' => [
                'name' => $randomRelic->name,
                'rarity' => $randomRelic->rarity
            ]
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
