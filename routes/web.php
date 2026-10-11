<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\BreedController;
use App\Http\Controllers\HorseController;
use App\Http\Controllers\Userzone\DashboardController;
use App\Http\Controllers\Userzone\LikeController;
use App\Http\Controllers\Userzone\MatchController;
use App\Http\Controllers\Userzone\MyHorseController;
use App\Http\Controllers\Userzone\ProfileController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

/*
 * Public Website routes
 */
Route::get('/', WelcomeController::class)->name('welcome');

Route::get('/horses', [HorseController::class, 'index'])->name('horses.index');
Route::get('/horses/{horse}', [HorseController::class, 'show'])->name('horses.show');
Route::get('/breeds', [BreedController::class, 'index'])->name('breeds.index');
Route::get('/breeds/{breed}', [BreedController::class, 'show'])->name('breeds.show');

/*
 * Authentication routes
 */
require __DIR__.'/auth.php';

/*
 * Userzone routes
 */
Route::middleware('auth')->group(function () {
    // For the user's dashboard (after login)
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    // For the user's own horses
    Route::get('/my/horses', [MyHorseController::class, 'index'])->name('my.horses.index');
    Route::get('/my/horses/create', [MyHorseController::class, 'create'])->name('my.horses.create');
    Route::post('/my/horses', [MyHorseController::class, 'store'])->name('my.horses.store');
    Route::get('/my/horses/{horse}/edit', [MyHorseController::class, 'edit'])->name('my.horses.edit');
    Route::put('/my/horses/{horse}', [MyHorseController::class, 'update'])->name('my.horses.update');
    Route::delete('/my/horses/{horse}', [MyHorseController::class, 'destroy'])->name('my.horses.destroy');

    // For liking other horses
    Route::post('/horses/{horse}/likes', [LikeController::class, 'store'])->name('likes.store');
    Route::delete('/likes/{like}', [LikeController::class, 'destroy'])->name('likes.destroy');

    // For the matches of the user's horses
    Route::get('/matches', [MatchController::class, 'index'])->name('matches.index');

    // For the user's profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
 * Admin routes
 */
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', AdminDashboardController::class)->name('dashboard');
});
