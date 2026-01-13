<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PatchesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CharactersController;
use App\Http\Controllers\LightconesController;
use App\Http\Controllers\RelicsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DisambiguationController;

// ======================
// Public Routes
// ======================

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Patch Listing
Route::get('/patches', [PatchesController::class, 'index'])->name('patches');

// Character Listing
Route::get('/characters', [CharactersController::class, 'index'])->name('characters.index');

Route::get('/characters/{character}', [CharactersController::class, 'show'])->name('characters.show');

// Lightcone Listing
Route::get('/lightcones', [LightconesController::class, 'index'])->name('lightcones.index');

Route::get('/lightcones/{lightcone}', [LightconesController::class, 'show'])->name('lightcones.show');

// Relic Listing
Route::get('/relics/{type}/{item}', [RelicsController::class, 'show'])->name('relics.show');
Route::get('/relics', [RelicsController::class, 'index'])->name('relics.index');

// Disambiguation
Route::get('/disambiguate', [DisambiguationController::class, 'show'])
    ->name('disambiguation.show');

// ======================
// Authentication Routes
// ======================

// Show login form
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Process login
Route::post('/login', [AuthController::class, 'login']);

// Change password
Route::post('/change-password', [AuthController::class, 'changePassword'])->name('password.change');

// Show registration form
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');

// Process registration
Route::post('/register', [AuthController::class, 'register']);

// Logout user
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ======================
// User Routes
// ======================
Route::middleware('auth')->group(function() {
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/settings', [UserController::class, 'index'])->name('user.settings');
    Route::get('/user/inventory', [UserController::class, 'index'])->name('user.inventory');
    Route::get('/user/characters', [UserController::class, 'index'])->name('user.characters');
});

