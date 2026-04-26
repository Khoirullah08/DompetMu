<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;  
use App\Http\Controllers\DashboardController;  
use App\Http\Controllers\CategoryController;  
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

    Route::get('/category', [CategoryController::class, 'index'])->name('category');
    Route::get('/category/tambah', [CategoryController::class, 'create'])->name('category.create');
    Route::get('/category/edit/$id', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('/category/update/$id', [CategoryController::class, 'update'])->name('category.update');
    Route::post('/category/delete/$id', [CategoryController::class, 'delete'])->name('category.delete');
});