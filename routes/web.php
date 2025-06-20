<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rute untuk Tamu (yang belum login)
Route::middleware('guest')->group(function () {
    Route::get('/', [LandingPageController::class, 'index'])->name('landing');
});


// Rute yang memerlukan login
Route::middleware('auth')->group(function () {
    
    // Rute utama setelah login
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('verified')->name('dashboard');

    // Rute Profil Pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- RUTE OPERASIONAL ---
    Route::resource('aset', AssetController::class);
    Route::resource('pinjam', LoanController::class);
    Route::post('pinjam/{loan}/return', [LoanController::class, 'returnAsset'])->name('pinjam.return');

    // --- RUTE PERSETUJUAN (Approval) ---
    Route::get('approval', [AssetController::class, 'approvalList'])->name('aset.approval')->middleware('permission:approve assets');
    Route::post('approval/{aset}/approve', [AssetController::class, 'approve'])->name('aset.approve')->middleware('permission:approve assets');
    Route::post('approval/{aset}/reject', [AssetController::class, 'reject'])->name('aset.reject')->middleware('permission:approve assets');

    // --- RUTE ADMINISTRASI (Hanya Admin) ---
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('kategori', CategoryController::class);
        Route::resource('lokasi', LocationController::class);
    });

});

require __DIR__.'/auth.php';