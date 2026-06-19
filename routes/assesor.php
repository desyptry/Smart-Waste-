<?php
use App\Http\Controllers\AssesorController;
use App\Http\Controllers\PickupScheduleController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\WithdrawalAssesorController; // Sesuaikan namespace jika ada di dalam sub-folder

// Dashboard Assesor (Mengarah ke AssesorController)
    Route::get('/dashboard', [AssesorController::class, 'index'])->name('assesor.dashboard');
    
    // Monitoring dan Laporan (Mengarah ke MonitoringController)
    Route::get('/monitoring', [MonitoringController::class, 'assesor'])->name('assesor.monitoring');
    
    // Verifikasi Jadwal (Mengarah ke PickupScheduleController)
    Route::get('/jadwal', [PickupScheduleController::class, 'index'])->name('assesor.jadwal');
    
    // Withdrawal (Mengarah ke WithdrawalController atau controller terkait)
    Route::get('/withdrawal', [WithdrawalAssesorController::class, 'index'])->name('assesor.withdrawal');