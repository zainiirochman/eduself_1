<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AnggotaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PerpustakaanController;
use App\Http\Controllers\RegisterPenggunaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});
Route::get('/login_pengguna', function () {
    return view('login_pengguna');
});
Route::get('/register_pengguna', function () {
    return view('register_pengguna');
})->name('register_pengguna');

Route::post('/register_pengguna', [RegisterPenggunaController::class, 'store'])->name('register_pengguna.store');

Route::get('/perpustakaan', [PerpustakaanController::class, 'index']);
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('admin/users', UserController::class);
    Route::resource('admin/books', BookController::class);
    Route::resource('admin/categories', CategoryController::class);
    Route::resource('admin/anggotas', AnggotaController::class);
});

require __DIR__.'/auth.php';