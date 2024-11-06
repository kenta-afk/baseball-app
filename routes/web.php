<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [GroupController::class, 'dashboard'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');
    Route::post('/groups', [GroupController::class, 'store'])->name('groups.store');
    Route::get('/groups/create', [GroupController::class, 'create'])->name('groups.create');
    Route::get('/groups/join', [GroupController::class, 'join'])->name('groups.join');
    Route::get('/groups/{group}', [GroupController::class, 'show'])->name('groups.show');
    Route::post('/groups/request-join', [GroupController::class, 'requestJoin'])->name('groups.requestJoin');
    Route::post('/groups/approve-join/{joinRequest}', [GroupController::class, 'approveJoin'])->name('groups.approveJoin');
    Route::delete('/groups/{group}', [GroupController::class, 'destroy'])->name('groups.destroy');
    Route::delete('/groups/{group}/remove-user/{user}', [GroupController::class, 'removeUser'])->name('groups.removeUser');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/dashboard', [GroupController::class, 'dashboard'])->name('dashboard');

    Route::get('/user/{user}/stats/edit', [UserController::class, 'editStats'])->name('user.stats.edit');
    Route::post('/user/{user}/stats/update', [UserController::class, 'updateStats'])->name('user.stats.update');
});

require __DIR__.'/auth.php';
