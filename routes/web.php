<?php

use App\Http\Controllers\ChoiceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EndingController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\NodeController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\RunController;
use App\Http\Controllers\Settings;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('auth')->group(function () {});

Route::resource('houses', HouseController::class);

Route::resource('nodes', NodeController::class);
Route::resource('choices', ChoiceController::class);

Route::middleware(['auth'])->group(function () {
    Route::resource('players', PlayerController::class);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/games', [GameController::class, 'index'])->name('games.index');
    Route::get('/games/create', [GameController::class, 'create'])->name('games.create');
    Route::post('/games/start', [GameController::class, 'start'])->name('games.start');
    Route::get('/games/{game}/play', [GameController::class, 'play'])->name('games.play');
    Route::post('/games/{game}/choice/{choice}', [GameController::class, 'makeChoice'])->name('games.choice');
    Route::get('/games/{game}/end', [GameController::class, 'endGame'])->name('games.end');

    Route::get('/runs', [RunController::class, 'index'])->name('runs.index');
    Route::get('/runs/{run}', [RunController::class, 'show'])->name('runs.show');

    Route::get('/endings', [EndingController::class, 'index'])->name('endings.index');

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
