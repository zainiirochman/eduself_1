<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AnggotaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PerpustakaanController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);
Route::get('/tentang_kami', function () {
    return view('tentang_kami');
});
Route::get('/login_pengguna', [PenggunaController::class, 'showLogin'])->name('login_pengguna');
Route::get('/register_pengguna', [PenggunaController::class, 'showRegister'])->name('register_pengguna');

Route::post('/register_pengguna', [PenggunaController::class, 'register'])->name('register_pengguna.store');
Route::post('/login_pengguna', [PenggunaController::class, 'login'])->name('login_pengguna.store');
Route::post('/logout_pengguna', [PenggunaController::class, 'logout'])->name('logout_pengguna');

Route::get('/perpustakaan', [PerpustakaanController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('admin/users', UserController::class);
    Route::resource('admin/books', BookController::class);
    Route::resource('admin/categories', CategoryController::class);
    Route::resource('admin/anggotas', AnggotaController::class);
});

require __DIR__.'/auth.php';