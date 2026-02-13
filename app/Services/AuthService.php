<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class AuthService
{
    /**
     * Handle an incoming registration request.
     */
    public function register(array $data, string $ip = '', string $browser = ''): User
    {
        $user = User::create([
            'username' => $data['username'],
            'firstname' => $data['firstname'],
            'middlename' => $data['middlename'] ?? null,
            'lastname' => $data['lastname'],
            'address' => $data['address'] ?? null,
            'contact_number' => $data['contact_number'] ?? null,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'ip' => $ip,
            'browser' => $browser,
            'credits' => 0,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return $user;
    }

    /**
     * Handle an incoming authentication request.
     */
    public function login(array $credentials, bool $remember = false, string $ip = '', string $browser = ''): void
    {
        $loginValue = $credentials['login'] ?? ($credentials['email'] ?? '');

        if ($this->tooManyAttempts($loginValue, $ip)) {
            $this->throwLockoutException($loginValue, $ip);
        }

        if (!Auth::attempt($credentials, $remember)) {
            RateLimiter::hit($this->throttleKey($loginValue, $ip));

            throw ValidationException::withMessages([
                'login' => trans('auth.failed'),
            ]);
        }

        // Update IP and browser on successful login
        $user = Auth::user();
        $user->update([
            'ip' => $ip,
            'browser' => $browser,
        ]);

        RateLimiter::clear($this->throttleKey($loginValue, $ip));
    }

    /**
     * Determine if there are too many failed login attempts.
     */
    protected function tooManyAttempts(string $login, string $ip): bool
    {
        return RateLimiter::tooManyAttempts($this->throttleKey($login, $ip), 5);
    }

    /**
     * Throw a validation exception for too many login attempts.
     */
    protected function throwLockoutException(string $login, string $ip): void
    {
        $seconds = RateLimiter::availableIn($this->throttleKey($login, $ip));

        throw ValidationException::withMessages([
            'login' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    protected function throttleKey(string $login, string $ip): string
    {
        return Str::transliterate(Str::lower($login).'|'.$ip);
    }
}
