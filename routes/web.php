<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingPageController; // 1. Tambahkan use statement ini
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 2. Ganti rute '/' yang lama dengan yang baru ini
Route::get('/', [LandingPageController::class, 'index'])->middleware('guest')->name('landing');


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('kategori', CategoryController::class);
    Route::resource('lokasi', LocationController::class);
    Route::resource('aset', AssetController::class);
});

require __DIR__.'/auth.php';