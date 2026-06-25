<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\WasteCategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
// Semua route admin
use App\Http\Controllers\WasteCategoryController;
use App\Http\Controllers\DropOffPointController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\ReportController;
//     Route::view('/dashboard', 'admin.dashboard')->name('admin.dashboard');
//     Route::view('/user', 'admin.user.index')->name('admin.user');
//     Route::view('/kategori', 'admin.kategori.index')->name('admin.kategori');
//     Route::view('/laporan', 'admin.laporan.index')->name('admin.laporan');
//     Route::view('/konfigurasi', 'admin.konfigurasi.index')->name('admin.konfigurasi');
//     Route::view('/posko', 'admin.posko.index')->name('admin.posko');
    
    
//     Route::prefix('admin')->group(function () {
    
// });// Route::middleware(['auth', 'role:admin'])->group(function () {
//     // Route::resource('/kategori', WasteCategoryController::class)->except(['show'])->names('admin.kategori');
// // });
//     // Route::delete('/kategori/{kategori}', [WasteCategoryController::class, 'destroy'])->name('admin.kategori.destroy');
//     Route::prefix('admin')->name('admin.')->group(function () {
    Route::name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    // Admin User CRUD
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user-alias', [UserController::class, 'index'])->name('user'); // Alias to match sidebar
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    // Admin Waste Category CRUD
    Route::get('/kategori', [WasteCategoryController::class, 'index'])->name('kategori.index');
    Route::post('/kategori', [WasteCategoryController::class, 'store'])->name('kategori.store');
    Route::put('/kategori/{wasteCategory}', [WasteCategoryController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{wasteCategory}', [WasteCategoryController::class, 'destroy'])->name('kategori.destroy');
    // Route::get('/user', [UserController::class, 'index'])->name('admin.user.index');
    // Route::post('/user', [UserController::class, 'store'])->name('admin.user.store');
    // Route::put('/user/{user}', [UserController::class, 'update'])->name('admin.user.update');
    // Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('admin.user.destroy');
    // Admin Posko (DropOffPoint) CRUD
    Route::get('/posko', [DropOffPointController::class, 'index'])->name('posko.index');
    Route::post('/posko', [DropOffPointController::class, 'store'])->name('posko.store');
    Route::put('/posko/{dropOffPoint}', [DropOffPointController::class, 'update'])->name('posko.update');
    Route::delete('/posko/{dropOffPoint}', [DropOffPointController::class, 'destroy'])->name('posko.destroy');
    // Admin Configurations
    Route::get('/konfigurasi', [ConfigurationController::class, 'index'])->name('konfigurasi.index');
    Route::put('/konfigurasi', [ConfigurationController::class, 'update'])->name('konfigurasi.update');
    // Admin Laporan (Report)
    Route::get('/laporan', [ReportController::class, 'adminIndex'])->name('laporan.index');
});