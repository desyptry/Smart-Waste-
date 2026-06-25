<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

  Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // UPDATE: Berikan dua nama agar dibaca aman oleh Breeze maupun Controller Anda
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard')->name('user.dashboard'); 

    // Dashboard untuk Officer
    Route::get('/officer/dashboard', function () {
        return view('officer.dashboard');
    })->name('officer.dashboard');

    // Dashboard untuk Admin
    // Route::get('/admin/dashboard', function () {
    //     return view('admin.dashboard');
    // })->name('admin.dashboard');

    // Dashboard untuk Assesor
    Route::get('/assesor/dashboard', function () {
        return view('assesor.dashboard');
    })->name('assesor.dashboard');

});


require __DIR__.'/auth.php';
