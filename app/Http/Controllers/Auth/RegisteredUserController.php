<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'username' => 'required|string|min:6|max:15|unique:'.User::class,
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'username' => $data['username'],
            'firstname' => $data['firstname'],
            'middlename' => $data['middlename'] ?? null,
            'lastname' => $data['lastname'],
            'address' => $data['address'] ?? null,
            'contact_number' => $data['contact_number'] ?? null,
            'email' => $data['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($data['password']),
            'ip' => $request->ip(),
            'browser' => $request->userAgent(),
            'credits' => 0,
        ]);

        event(new \Illuminate\Auth\Events\Registered($user));

        \Illuminate\Support\Facades\Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
