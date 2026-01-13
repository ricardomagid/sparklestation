<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SyncController;
use App\Http\Controllers\Api\PatchController;
use App\Http\Controllers\Api\RelicController;
use App\Http\Controllers\Api\RelicInventoryController;
use App\Http\Controllers\Api\UserController;

// Database changes
Route::post('/sync', [SyncController::class, 'store']);

// Patches
Route::get('/patches/{patch}', [PatchController::class, 'show']);

// Relics
Route::get('/relics/relic/{selectedItem}', [RelicController::class, 'getRelicData'])->name('api.relic.show');
Route::get('/relics/planar/{selectedItem}', [RelicController::class, 'getPlanarData'])->name('api.planar.show');

// User Profile Pic
Route::post('/profile/upload', [UserController::class, 'uploadProfile'])
    ->name('profile.upload')
    ->middleware('web');

Route::post('/profile/update', [UserController::class, 'updateProfile'])
    ->name('profile.update')
    ->middleware('web');

// User Preferences
Route::post('/user/update', [UserController::class, 'updateUserPreferences'])->name('user-preferences.update')->middleware('web');

// Email Verification
Route::post('/email/verification', [UserController::class, 'sendVerificationEmail'])->name('email-verification')->middleware('web');

// User Inventory
Route::get('/inventory', [RelicInventoryController::class, 'index'])->name('inventory.index')->middleware('web');
Route::post('/relics/generate', [RelicInventoryController::class, 'generateRelics'])->name('relics.generate')->middleware('web');