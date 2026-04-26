<?php

use App\Http\Controllers\ArchivistController;
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

// ── PUBLIC ROUTES ──
Route::get('/', function () {
    return view('welcome');
})->name('landing');

// ── PROTECTED ROUTES (Archivist & Player) ──
Route::middleware(['auth'])->group(function () {

    // The Archivist: Static Content CRUD

    // CUSTOM TRASH ROUTES MUST GO ABOVE THE RESOURCE ROUTE!
    Route::get('/houses/trashed', [HouseController::class, 'trashed'])->name('houses.trashed');
    Route::post('/houses/{id}/restore', [HouseController::class, 'restore'])->name('houses.restore');
    Route::delete('/houses/{id}/force-delete', [HouseController::class, 'forceDelete'])->name('houses.forceDelete');

    // The Three-Eyed Raven: Archivist Agent
    Route::post('/houses/archivist', [ArchivistController::class, 'query'])->name('houses.archivist');

    // Standard Resources
    Route::resource('houses', HouseController::class);
    Route::resource('nodes', NodeController::class);
    Route::resource('choices', ChoiceController::class);
    Route::resource('endings', EndingController::class);

    // The Player: Meta-Progression
    Route::resource('players', PlayerController::class);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // The Engine: Gameplay Loop
    Route::prefix('games')->name('games.')->group(function () {
        Route::get('/', [GameController::class, 'index'])->name('index');
        Route::get('/create', [GameController::class, 'create'])->name('create');
        Route::post('/start', [GameController::class, 'start'])->name('start');
        Route::get('/{game}/play', [GameController::class, 'play'])->name('play');
        Route::post('/{game}/choice/{choice}', [GameController::class, 'makeChoice'])->name('choice');
        Route::get('/{game}/end', [GameController::class, 'endGame'])->name('end');
    });

    // The Archives: Run History
    Route::get('/runs', [RunController::class, 'index'])->name('runs.index');
    Route::get('/runs/{run}', [RunController::class, 'show'])->name('runs.show');

    // Standard Breeze Profile Settings
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
