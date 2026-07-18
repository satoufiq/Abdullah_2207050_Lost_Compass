<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('pages.signup');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'pirate_name' => 'required|string|min:3|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'string', 'min:6', Rules\Password::defaults()],
            'allegiance' => 'required|string|in:Independent,Brethren of the Coast,Royal Navy,Spanish Fleet',
        ]);

        $user = User::create([
            'name' => $request->input('pirate_name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'), // Hashed via cast in User model
            'pirate_name' => $request->input('pirate_name'),
            'allegiance' => $request->input('allegiance'),
            'rank' => 'Deckhand',
            'identity_character' => $request->input('identity_character'),
            'ship' => $request->input('ship'),
            'weapon' => $request->input('weapon'),
            'relic' => $request->input('relic'),
            'avatar' => $request->input('avatar'),
        ]);

        $request->session()->forget('quiz_identity_data');

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('home'));
    }
}
