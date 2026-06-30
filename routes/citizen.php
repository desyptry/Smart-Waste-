<?php

use App\Http\Controllers\WasteCatalogController;
use App\Http\Controllers\WithdrawalController;
use Illuminate\Support\Facades\Route;


Route::view('/', 'user.index');
    Route::get('/pencairan', [WithdrawalController::class, 'index'])->name('user.withdrawal');
    Route::post('/pencairan', [WithdrawalController::class, 'store'])->name('user.withdrawal.store');
    Route::view('/dashboard', 'user.dashboard.index')->name('user.dashboard');
    Route::view('/riwayat', 'user.riwayat.index')->name('user.riwayat');
    Route::view('/jadwal', 'user.jadwal.index')->name('user.jadwal');
    Route::view('/jadwal', 'user.jadwal.index')->name('user.jadwal');
    Route::view('/jadwal/{i}', 'user.jadwal.show')->name('user.jadwal.show');
    Route::view('/sampah/{i}', 'user.katalog-sampah.show')->name('user.sampah.show');

    Route::get('/katalog-sampah', [WasteCatalogController::class, 'index'])->name('user.katalog-sampah');