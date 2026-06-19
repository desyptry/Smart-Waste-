<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WithdrawalAssesorController extends Controller
{
    /**
     * Menampilkan halaman daftar pencairan dana (withdrawal) untuk assesor.
     */
    public function index()
    {
        // Mengarah ke file resource: resources/views/assesor/withdrawal.blade.php
        return view('assesor.withdrawal.index');
    }
}
