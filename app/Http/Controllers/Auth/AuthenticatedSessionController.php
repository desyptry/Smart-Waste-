<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();

    $request->session()->regenerate();

    // Ambil data user yang baru saja login
    $user = $request->user();

    // Redirect berdasarkan role
    switch ($user->role) {
        case 'admin':
            return redirect(route('admin.dashboard', absolute: false));
        case 'officer':
            return redirect(route('officer.dashboard', absolute: false));
        case 'assesor':
            return redirect(route('assesor.dashboard', absolute: false));
        case 'citizen':
        default:
            return redirect(route('user.dashboard', absolute: false)); // user/dashboard
    }
}


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
