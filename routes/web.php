<?php

use Illuminate\Support\Facades\Route;

// Redirect awal ke dashboard
Route::get('/admin', function () {
    return redirect('/admin/dashboard');
});

// Semua route admin
Route::prefix('admin')->group(function () {

    Route::view('/dashboard', 'admin.dashboard');
    Route::view('/user', 'admin.user.index');
    Route::view('/laporan', 'admin.laporan.index');
    Route::view('/konfigurasi', 'admin.konfigurasi.index');
    Route::view('/posko', 'admin.posko.index');

});
Route::prefix('officer')->group(function () {

    Route::view('/dashboard', 'officer.dashboard');
    Route::view('/warga', 'officer.warga.index');
    Route::view('/setoran', 'officer.setoran.index');
    Route::view('/monitoring', 'officer.monitoring.index');
    Route::view('/verifikasi', 'officer.verifikasi.index');
    Route::view('/jadwal', 'officer.jadwal.index');
    Route::view('/sampah', 'officer.sampah.index');

});