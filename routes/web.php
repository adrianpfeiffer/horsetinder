<?php

use App\Http\Controllers\BreedController;
use App\Http\Controllers\HorseController;
use App\Http\Controllers\Userzone\DashboardController;
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

    // Todo: add your Userzone routes here

    // For the user's profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
