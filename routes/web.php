<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OnlineUserController;
use App\Http\Controllers\ProfileImageController;
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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/shop', function () { return Inertia::render('Shop/Index'); })->name('shop');
    Route::get('/chatrooms', function () { return Inertia::render('Chatrooms/Index'); })->name('chatrooms');
    Route::get('/forum', function () { return Inertia::render('Forum/Index'); })->name('forum');
    Route::get('/friends', function () { return Inertia::render('Friends/Index'); })->name('friends');
    Route::get('/statistics', function () { return Inertia::render('Statistics/Index'); })->name('statistics');
    Route::get('/pet-wars', function () { return Inertia::render('PetWars/Index'); })->name('petwars');
    Route::get('/settings', function () { return Inertia::render('Settings/Index'); })->name('settings');
    Route::get('/staff-panel', function () { return Inertia::render('StaffPanel/Index'); })->name('staff.panel');
    Route::get('/vip-panel', function () { return Inertia::render('VipPanel/Index'); })->name('vip.panel');
});

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/all-posts', [\App\Http\Controllers\PostController::class, 'index'])->name('posts.index');
    Route::post('/posts', [\App\Http\Controllers\PostController::class, 'store'])->name('posts.store');
    Route::post('/posts/{post}/like', [\App\Http\Controllers\PostLikeController::class, 'toggle'])->name('posts.like');
    Route::get('/posts/{post}/comments', [\App\Http\Controllers\PostCommentController::class, 'index'])->name('comments.index');
    Route::post('/posts/{post}/comments', [\App\Http\Controllers\PostCommentController::class, 'store'])->name('comments.store');

    Route::get('/{user:username}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/{user:username}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/profile/image/{type}', [ProfileImageController::class, 'store'])->name('profile.image.store');
    // Background Data Endpoints (moved from api.php)
});

Route::get('/profile/image/{type}/{userId}/{fileName?}', [ProfileImageController::class, 'show'])->name('profile.image.show');
