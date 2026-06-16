<?php

use Illuminate\Support\Facades\Route;



Route::view('/', 'welcome');
Route::view('login', 'login')->name('login');
Route::view('daftar', 'register')->name('daftar');

// Route::get('/admin/kategori', function () {
//     return view('admin.kategori.index');
// });