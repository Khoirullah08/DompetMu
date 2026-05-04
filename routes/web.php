<?php


use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DompetController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('login');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
});

Route::middleware('guest')->group(function () {
    Route::get('/login',    [LoginController::class, 'index'])->name('login');
    Route::post('/login',   [LoginController::class, 'store']);
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register',[RegisterController::class, 'store'])->name('register.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])
->middleware('auth')
->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
// Profile routes
    Route::get('/profile',        [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit',   [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('category')->name('category.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/store', [CategoryController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [CategoryController::class, 'destroy'])->name('delete');
    });

    Route::prefix('dompet')->name('dompet.')->group(function () {
        Route::get('/', [DompetController::class, 'index'])->name('index');
        Route::post('store', [DompetController::class, 'store'])->name('store');
        Route::get('/create', [DompetController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [DompetController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [DompetController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [DompetController::class, 'delete'])->name('delete');
    });

    // Transaksi routes 
    Route::prefix('transaksi')->name('transaksi.')->group(function () {
        Route::get('/',           [TransaksiController::class, 'index'])->name('index');
        Route::get('/create',     [TransaksiController::class, 'create'])->name('create');
        Route::post('/store',     [TransaksiController::class, 'store'])->name('store');
        Route::get('/edit/{id}',  [TransaksiController::class, 'edit'])->name('edit');
        Route::put('/update/{id}',[TransaksiController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [TransaksiController::class, 'destroy'])->name('delete');
    });
});
