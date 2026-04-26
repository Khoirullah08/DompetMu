<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;  
use App\Http\Controllers\DashboardController; 
use App\Http\Controllers\ProfileController; 
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('login');
});

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login',    [LoginController::class, 'index'])->name('login');
    Route::post('/login',   [LoginController::class, 'store']);
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register',[RegisterController::class, 'store'])->name('register.store');
});

// Logout route
Route::post('/logout', [LoginController::class, 'destroy'])
->middleware('auth')
->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile',         [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',      [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/security',     [ProfileController::class, 'security'])->name('profile.security');
    Route::get('/teams',        [ProfileController::class, 'teams'])->name('profile.teams');
    Route::get('/team-member',  [ProfileController::class, 'teamMember'])->name('profile.team-member');
    Route::get('/notifications',[ProfileController::class, 'notifications'])->name('profile.notifications');
    Route::get('/billing',      [ProfileController::class, 'billing'])->name('profile.billing');
    Route::get('/data-export',  [ProfileController::class, 'dataExport'])->name('profile.data-export');
    Route::get('/delete',       [ProfileController::class, 'deleteConfirm'])->name('profile.delete');

});