<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WasteCatalogController;

Route::view('/', 'user.index');
    Route::view('/dashboard', 'user.dashboard.index')->name('user.dashboard');
    Route::view('/pencairan', 'user.pencairan.index')->name('user.pencairan');
    Route::view('/riwayat', 'user.riwayat.index')->name('user.riwayat');
    Route::view('/jadwal', 'user.jadwal.index')->name('user.jadwal');
    Route::view('/jadwal', 'user.jadwal.index')->name('user.jadwal');
    Route::view('/jadwal/{i}', 'user.jadwal.show')->name('user.jadwal.show');
    Route::view('/sampah/{i}', 'user.katalog-sampah.show')->name('user.sampah.show');

    Route::get('/katalog-sampah', [WasteCatalogController::class, 'index'])->name('user.katalog-sampah');