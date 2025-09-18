<?php

use App\Http\Controllers\Admin\DashboardController; // Pastikan ini ada di atas
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AnggotaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Modifikasi grup rute dari Breeze
Route::middleware('auth')->group(function () {
    // HAPUS RUTE '/dashboard' BAWAAN BREEZE
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');

    // PINDAHKAN RUTE ADMIN ANDA KE SINI DAN BERI NAMA 'dashboard'
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('admin/users', UserController::class);
    Route::resource('admin/books', BookController::class);
    Route::resource('admin/categories', CategoryController::class);
    Route::resource('admin/anggotas', AnggotaController::class);

    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';