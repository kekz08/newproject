<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OnlineUserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Landing/Index', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->middleware('guest');

Route::get('/dashboard', function () {
    return Inertia::render('Home/Index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/home', function () {
    return redirect()->route('dashboard');
});

Route::get('/tos', function () {
    return Inertia::render('Legal/Terms/Index');
})->middleware('guest')->name('terms');

Route::get('/privacy', function () {
    return Inertia::render('Legal/PrivacyPolicy/Index');
})->middleware('guest')->name('privacy');

Route::get('/cookies', function () {
    return Inertia::render('Legal/CookiesPolicy/Index');
})->middleware('guest')->name('cookies');

Route::get('/online-users', [OnlineUserController::class, 'index'])->name('online.users');

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/{user:username}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/{user:username}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Background Data Endpoints (moved from api.php)
});
