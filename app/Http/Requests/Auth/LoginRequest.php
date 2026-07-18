<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'alias' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $alias = $this->input('alias');
        $password = $this->input('password');
        $remember = $this->boolean('remember');

        $authenticated = false;

        // Try email login first
        if (Auth::attempt(['email' => $alias, 'password' => $password], $remember)) {
            $authenticated = true;
        }

        // Try name (username/alias)
        if (!$authenticated) {
            $user = User::where('name', $alias)->first();
            if ($user && \Hash::check($password, $user->password)) {
                Auth::login($user, $remember);
                $authenticated = true;
            }
        }

        // Try profile pirate_name
        if (!$authenticated) {
            $profile = \App\Models\PirateProfile::where('pirate_name', $alias)->first();
            if ($profile) {
                $user = $profile->user;
                if ($user && \Hash::check($password, $user->password)) {
                    Auth::login($user, $remember);
                    $authenticated = true;
                }
            }
        }

        if (!$authenticated) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'alias' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('alias')).'|'.$this->ip());
    }
}
