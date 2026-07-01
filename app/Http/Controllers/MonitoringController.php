<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    /**
     * Menampilkan halaman monitoring dan laporan untuk assesor.
     */
    public function index()
    {
 return;
    }

  public function assesor(){
    return view('assesor.monitoring.index');
  }
}
