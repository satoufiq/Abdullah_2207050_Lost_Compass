<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\Quote;
use App\Models\UserMission;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     *
     * Backend flow:
     * 1. Check if user is authenticated
     * 2. If yes → load pirate profile, personalized greeting, continue mission
     * 3. Load featured missions from DB
     * 4. Load random pirate quote
     * 5. Pass all data to view
     */
    public function index()
    {
        $data = [
            'isLoggedIn' => false,
            'pirateName' => null,
            'pirateRank' => null,
            'pirateShip' => null,
            'greeting' => 'Choose your fate upon the Seven Seas',
            'ctaText' => 'Begin Voyage',
            'ctaLink' => route('signup'),
            'continueMission' => null,
            'unreadNotifications' => 0,
        ];

        // ─── Authenticated User Logic ─────────────────────────
        if (Auth::check()) {
            $user = Auth::user();
            $profile = $user->pirateProfile;

            $data['isLoggedIn'] = true;
            $data['pirateName'] = $profile->pirate_name ?? $user->name;
            $data['pirateRank'] = $profile->rank ?? 'Deckhand';
            $data['pirateShip'] = $profile->ship ?? null;

            // Dynamic personalized greeting
            $greetings = [
                "Welcome back, Captain {$data['pirateName']}. The sea still whispers your name.",
                "The tides have been waiting, Captain {$data['pirateName']}.",
                "Captain {$data['pirateName']}, your compass points true once more.",
                "Ahoy, Captain {$data['pirateName']}! The crew has been restless.",
                "The horizon calls you, Captain {$data['pirateName']}.",
            ];
            $data['greeting'] = $greetings[array_rand($greetings)];

            // Change CTA for logged-in users
            $data['ctaText'] = 'Continue Journey';
            $data['ctaLink'] = route('missions');

            // Check for latest pending/in-progress mission
            $latestMission = UserMission::where('user_id', $user->id)
                ->whereIn('status', ['pending', 'in_progress'])
                ->orderBy('updated_at', 'desc')
                ->with('mission')
                ->first();

            if ($latestMission && $latestMission->mission) {
                $data['continueMission'] = $latestMission->mission;
            }

            // Unread notification count
            $data['unreadNotifications'] = $user->notifications()
                ->where('read_status', false)
                ->count();
        }

        // ─── Featured Missions (for all users) ───────────────
        $data['featuredMissions'] = Mission::featured()
            ->limit(3)
            ->get();

        // ─── Random Pirate Quote ──────────────────────────────
        $data['randomQuote'] = Quote::inRandomOrder()->first();

        // ─── All quotes for the quote carousel ────────────────
        $data['allQuotes'] = Quote::all();

        return view('pages.home', $data);
    }
}
