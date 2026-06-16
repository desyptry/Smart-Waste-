<?php

use Illuminate\Support\Facades\Route;

    Route::view('/dashboard', 'officer.dashboard')->name('officer.dashboard');
    Route::view('/monitoring', 'officer.monitoring.index')->name('officer.monitoring');
   
    Route::prefix('jadwal')->group(function (){
      Route::view('/', 'officer.jadwal.index')->name('officer.jadwal');
      Route::view('/create', 'officer.jadwal.create')->name('officer.jadwal.create');
      
      Route::prefix('1')->group(function (){
        Route::view('/', 'officer.jadwal.detail-jadwal.index')->name('officer.jadwal.detail');
        Route::prefix('setoran')->group(function(){
          Route::view('/', 'officer.jadwal.detail-jadwal.setoran.index')->name('officer.jadwal.detail.setoran');
        });
        Route::prefix('harga')->group(function (){
          Route::view('/', 'officer.jadwal.detail-jadwal.harga.index')->name('officer.jadwal.detail.harga');
        });
        
      });
    });
