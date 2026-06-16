<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WasteCategoryController;
use App\Http\Controllers\UserController;
// Semua route admin

    Route::view('/dashboard', 'admin.dashboard')->name('admin.dashboard');
    Route::view('/user', 'admin.user.index')->name('admin.user');
    Route::view('/kategori', 'admin.kategori.index')->name('admin.kategori');
    Route::view('/laporan', 'admin.laporan.index')->name('admin.laporan');
    Route::view('/konfigurasi', 'admin.konfigurasi.index')->name('admin.konfigurasi');
    Route::view('/posko', 'admin.posko.index')->name('admin.posko');
    
    
    Route::prefix('admin')->group(function () {
    
});// Route::middleware(['auth', 'role:admin'])->group(function () {
    // Route::resource('/kategori', WasteCategoryController::class)->except(['show'])->names('admin.kategori');
// });
    Route::delete('/kategori/{kategori}', [WasteCategoryController::class, 'destroy'])->name('admin.kategori.destroy');
    Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/kategori', [WasteCategoryController::class, 'index'])->name('kategori.index');
    Route::post('/kategori', [WasteCategoryController::class, 'store'])->name('kategori.store');
    Route::put('/kategori/{wasteCategory}', [WasteCategoryController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{wasteCategory}', [WasteCategoryController::class, 'destroy'])->name('kategori.destroy');
    Route::get('/user', [UserController::class, 'index'])->name('admin.user.index');
    Route::post('/user', [UserController::class, 'store'])->name('admin.user.store');
    Route::put('/user/{user}', [UserController::class, 'update'])->name('admin.user.update');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('admin.user.destroy');
});