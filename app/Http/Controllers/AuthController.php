<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PirateProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Show the login form.
     * Redirects to home if already authenticated.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('pages.login');
    }

    /**
     * Handle login form submission.
     * Accepts either email or pirate name as the alias field.
     */
    public function login(Request $request)
    {
        $request->validate([
            'alias' => 'required|string',
            'password' => 'required|string',
        ]);

        $alias = $request->input('alias');
        $password = $request->input('password');
        $remember = $request->boolean('remember');

        // Try login by email first
        if (Auth::attempt(['email' => $alias, 'password' => $password], $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }

        // Try login by name (pirate alias)
        $user = User::where('name', $alias)->first();
        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user, $remember);
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }

        // Try login by pirate_name in profiles
        $profile = PirateProfile::where('pirate_name', $alias)->first();
        if ($profile) {
            $user = $profile->user;
            if ($user && Hash::check($password, $user->password)) {
                Auth::login($user, $remember);
                $request->session()->regenerate();
                return redirect()->intended(route('home'));
            }
        }

        return back()->withErrors([
            'alias' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('alias', 'remember'));
    }

    /**
     * Show the signup form.
     * Redirects to home if already authenticated.
     */
    public function showSignup()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('pages.signup');
    }

    /**
     * Handle signup form submission.
     * Creates a User and a PirateProfile, then logs in.
     */
    public function signup(Request $request)
    {
        $request->validate([
            'pirate_name' => 'required|string|min:3|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'string', 'min:6', Password::defaults()],
            'allegiance' => 'required|string|in:Independent,Brethren of the Coast,Royal Navy,Spanish Fleet',
        ]);

        // Create the user account
        $user = User::create([
            'name' => $request->input('pirate_name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'), // Hashed via cast
            'pirate_name' => $request->input('pirate_name'),
            'allegiance' => $request->input('allegiance'),
            'rank' => 'Deckhand',
            'identity_character' => $request->input('identity_character'),
            'ship' => $request->input('ship'),
            'weapon' => $request->input('weapon'),
            'relic' => $request->input('relic'),
            'avatar' => $request->input('avatar'),
        ]);

        // Clear the quiz session data now that we used it
        $request->session()->forget('quiz_identity_data');

        // Log in the new user
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home');
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
