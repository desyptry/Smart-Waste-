<?php
use App\Http\Controllers\AssesorController;
use App\Http\Controllers\AssesorMonitoringController;
use App\Http\Controllers\AssesorScheduleController;
use App\Http\Controllers\AssesorWithdrawalController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\PickupScheduleController;
use App\Http\Controllers\WithdrawalAssesorController; // Sesuaikan namespace jika ada di dalam sub-folder




// Dashboard Assesor (Mengarah ke AssesorController)
    Route::get('/dashboard', [AssesorController::class, 'index'])->name('assesor.dashboard');
    
Route::prefix('/laporan')->group(function () {
    Route::get('/', [AssesorMonitoringController::class, 'index'])->name('assesor.laporan');
});
    // Verifikasi Jadwal (Mengarah ke PickupScheduleController)
Route::prefix('/jadwal')->group(function () {
    Route::get('/', [AssesorScheduleController::class, 'index'])->name('assesor.jadwal');
    Route::get('/{id}/review', [AssesorScheduleController::class, 'review'])->name('assesor.jadwal.review');
    Route::post('/{id}/verify', [AssesorScheduleController::class, 'verify'])->name('assesor.jadwal.verify');
    
});
Route::prefix('/withdrawal')->group(function () {
    Route::get('/', [AssesorWithdrawalController::class, 'index'])->name('assesor.withdrawal');
    Route::post('/{id}/verify', [AssesorWithdrawalController::class, 'verify'])->name('assesor.withdrawal.verify');
});