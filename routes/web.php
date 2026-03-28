<?php

use App\Http\Controllers\HouseController;
use App\Http\Controllers\Settings;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('auth')->group(function () {});

Route::resource('houses', HouseController::class);

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('profile', [Settings\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [Settings\ProfileController::class, 'update'])->name('profile.update');
        Route::delete('profile', [Settings\ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::get('password', [Settings\PasswordController::class, 'edit'])->name('password.edit');
        Route::put('password', [Settings\PasswordController::class, 'update'])->name('password.update');
        Route::get('appearance', [Settings\AppearanceController::class, 'edit'])->name('appearance.edit');
        Route::put('appearance', [Settings\AppearanceController::class, 'update'])->name('appearance.update');
    });
});

require __DIR__.'/auth.php';
