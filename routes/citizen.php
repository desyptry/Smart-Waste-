<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WasteCatalogController;
use App\Http\Controllers\CitizenController;
use App\Http\Controllers\WithdrawalController;
Route::view('/', 'user.index');
Route::get('/dashboard', [CitizenController::class, 'dashboard'])->name('user.dashboard');
Route::get('/pencairan', [WithdrawalController::class, 'index'])->name('user.pencairan');
Route::post('/pencairan', [WithdrawalController::class, 'store'])->name('user.pencairan.store');
Route::get('/riwayat', [CitizenController::class, 'riwayat'])->name('user.riwayat');
Route::get('/jadwal', [CitizenController::class, 'jadwal'])->name('user.jadwal');
Route::get('/jadwal/{id}', [CitizenController::class, 'jadwalShow'])->name('user.jadwal.show');
Route::get('/katalog-sampah', [WasteCatalogController::class, 'index'])->name('user.katalog-sampah');
Route::get('/sampah/{id}', [WasteCatalogController::class, 'show'])->name('user.sampah.show');