<?php

declare(strict_types=1);

use App\Http\Controllers\PostController;
use App\Http\Controllers\PostShowController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('posts', 'post.index')
    ->middleware(['auth', 'verified'])
    ->name('posts.index');

Route::view('posts/create', 'post.create')
    ->middleware(['auth', 'verified'])
    ->name('posts.create');

Route::get('posts/edit/{post}', [PostController::class, 'edit'])
    ->middleware(['auth', 'verified'])
    ->name('posts.edit');

Route::get('posts/{post:slug}', PostShowController::class)->name('posts.show');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
