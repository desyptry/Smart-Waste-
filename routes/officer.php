<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PickupScheduleController;
use App\Http\Controllers\SchedulePriceController;
use App\Http\Controllers\DepositHistoryController;

Route::view('/dashboard', 'officer.dashboard')->name('officer.dashboard');
Route::view('/monitoring', 'officer.monitoring.index')->name('officer.monitoring');

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
