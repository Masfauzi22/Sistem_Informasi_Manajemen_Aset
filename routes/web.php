<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [LandingPageController::class, 'index'])->middleware('guest')->name('landing');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Rute untuk Aset bisa diakses semua user yang login
    Route::resource('aset', AssetController::class);
    
    // ==========================================================
    // PERUBAHAN DI SINI: Grup middleware 'role' dihapus, dan
    // diganti dengan middleware 'permission' di setiap rute.
    // ==========================================================

    // Hanya user dengan izin 'manage categories' yang bisa akses
    Route::resource('kategori', CategoryController::class)->middleware('permission:manage categories');
    
    // Hanya user dengan izin 'manage locations' yang bisa akses
    Route::resource('lokasi', LocationController::class)->middleware('permission:manage locations');
    
    // Hanya user dengan izin 'manage users' yang bisa akses
    Route::resource('users', UserController::class)->middleware('permission:manage users');
});

require __DIR__.'/auth.php';