<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route; // Pastikan ini di-import jika belum ada

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            // Rute untuk Officer (Wajib Login & Harus Officer)
            Route::middleware(['web', 'auth', 'role:officer'])
                ->prefix('officer')
                ->group(base_path('routes/officer.php'));

            // Rute untuk Admin (Wajib Login & Harus Admin)
            Route::middleware(['web', 'auth', 'role:admin'])
                ->prefix('admin')
                ->group(base_path('routes/admin.php'));

            // Rute untuk Assesor (Wajib Login & Harus Assesor)
            Route::middleware(['web', 'auth', 'role:assesor'])
                ->prefix('assesor')
                ->group(base_path('routes/assesor.php'));

            // Rute untuk Citizen/User (Wajib Login & Harus Citizen)
            Route::middleware(['web', 'auth', 'role:citizen']) // Sesuaikan parameter string 'citizen' dengan logika di RoleMiddleware Anda
                ->prefix('user')
                ->group(base_path('routes/citizen.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Alias middleware kustom Anda tetap di sini
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
