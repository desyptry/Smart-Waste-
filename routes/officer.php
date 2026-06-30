<?php

use App\Http\Controllers\DepositHistoryController;
use App\Http\Controllers\PickupScheduleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SchedulePriceController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\OfficerController;

Route::get('/dashboard', [OfficerController::class, 'index'])->name('officer.dashboard');
Route::prefix('laporan')->group(function () {
Route::get('/', [ReportController::class, 'index'])->name('officer.laporan.index');
    Route::get('/export/excel', [ReportController::class, 'exportExcel'])->name('officer.laporan.excel');

    // Navigasi halaman detail & export tunggal
    Route::get('/{id}/show', [ReportController::class, 'showPage'])->name('officer.laporan.showPage');
    Route::get('/{id}/export-single', [ReportController::class, 'exportSingleExcel'])->name('officer.laporan.exportSingle');
});
Route::prefix('jadwal')->group(function () {
    Route::get('/', [PickupScheduleController::class, "index"])->name('officer.jadwal');
    Route::get('/create', [PickupScheduleController::class, 'create'])->name('officer.jadwal.create');
    Route::post('/store', [PickupScheduleController::class, 'store'])->name('officer.jadwal.store');
    
    Route::get('/edit/{id}', [PickupScheduleController::class, 'edit'])->name('officer.jadwal.edit');
    Route::put('/update/{id}', [PickupScheduleController::class, 'update'])->name('officer.jadwal.update');
    
    // Diubah menjadi DELETE action ke Controller, bukan sekadar merender View statis
    Route::delete('/delete/{id}', [PickupScheduleController::class, 'destroy'])->name('officer.jadwal.delete');

    // Mengubah prefix statis '1' menjadi parameter dinamis '{id}'
    Route::prefix('{id}')->group(function () {
        Route::get('/', [PickupScheduleController::class, 'show'])->name('officer.jadwal.detail');
           Route::get('/setoran', [PickupScheduleController::class, 'setoran'])->name('officer.jadwal.detail.setoran');
    
    // Rute penyimpan data transaksi setoran
    Route::post('/setoran/store', [PickupScheduleController::class, 'storeSetoran'])->name('officer.jadwal.detail.setoran.store');
        // Kelola Harga Sampah (SchedulePrice)
Route::get('/harga', [SchedulePriceController::class, 'index'])->name('officer.jadwal.detail.harga');
    Route::post('/harga/sync', [SchedulePriceController::class, 'syncPrices'])->name('officer.jadwal.detail.harga.sync');
    
    // Jalur hapus item baris tabel harga
    Route::delete('/harga/delete/{priceId}', [SchedulePriceController::class, 'destroyPrice'])->name('officer.jadwal.detail.harga.delete');

      Route::get('/riwayat', [DepositHistoryController::class, 'index'])->name('officer.jadwal.detail.riwayat');
});
});
