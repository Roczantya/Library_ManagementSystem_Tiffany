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
    $request->authenticate();  // Autentikasi menggunakan LoginRequest

    $request->session()->regenerate(); // Regenerasi session setelah login

    // Cek role pengguna dan arahkan sesuai dengan role mereka
    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard'); // Halaman dashboard admin
    } elseif (Auth::user()->role === 'librarian') {
        return redirect()->route('librarian.dashboard'); // Halaman dashboard librarian
    } elseif (Auth::user()->role === 'mahasiswa') {
        return redirect()->route('mahasiswa.dashboard'); // Halaman dashboard mahasiswa
    }

    // Default redirection jika tidak ada role yang ditemukan
    return redirect()->route('/'); // Redirect ke halaman default
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
