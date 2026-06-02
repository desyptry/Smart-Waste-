<?php

use Illuminate\Support\Facades\Route;

// Semua route admin
Route::prefix('admin')->group(function () {
    Route::view('/dashboard', 'admin.dashboard')->name('admin.dashboard');
    Route::view('/user', 'admin.user.index')->name('admin.user');
    Route::view('/kategori', 'admin.kategori.index')->name('admin.kategori');
    Route::view('/laporan', 'admin.laporan.index')->name('admin.laporan');
    Route::view('/konfigurasi', 'admin.konfigurasi.index')->name('admin.konfigurasi');
    Route::view('/posko', 'admin.posko.index')->name('admin.posko');
});
Route::prefix('officer')->group(function () {
    Route::view('/dashboard', 'officer.dashboard')->name('officer.dashboard');
    Route::view('/warga', 'officer.warga.index')->name('officer.warga');
    Route::view('/setoran', 'officer.setoran.index')->name('officer.setoran');
    Route::view('/monitoring', 'officer.monitoring.index')->name('officer.monitoring');
    Route::view('/verifikasi', 'officer.verifikasi.index')->name('officer.verifikasi');
    Route::view('/jadwal', 'officer.jadwal.index')->name('officer.jadwal');
    Route::view('/sampah', 'officer.sampah.index')->name('officer.sampah');
});

Route::view('/', 'welcome');
Route::view('login', 'login')->name('login');
Route::view('daftar', 'register')->name('daftar');
Route::prefix('user')->group(function(){
    Route::view('/', 'user.index');
    Route::view('/dashboard', 'user.dashboard.index')->name('user.dashboard');
    Route::view('/pencairan', 'user.pencairan.index')->name('user.pencairan');
    Route::view('/riwayat', 'user.riwayat.index')->name('user.riwayat');
    Route::view('/jadwal', 'user.jadwal.index')->name('user.jadwal');
    Route::view('/jadwal', 'user.jadwal.index')->name('user.jadwal');
    Route::view('/jadwal/{i}', 'user.jadwal.show')->name('user.jadwal.show');
    Route::view('/sampah/{i}', 'user.katalog-sampah.show')->name('user.sampah.show');

    Route::view('/katalog-sampah', 'user.katalog-sampah.index')->name('user.katalog-sampah');
});
// Route::get('/admin/kategori', function () {
//     return view('admin.kategori.index');
// });