<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Cek apakah user sudah login dan role-nya sesuai
        if (Auth::check() && Auth::user()->role === $role) {
            // Jika sesuai, lanjutkan permintaan
            return $next($request);
        }

        // Jika tidak sesuai, redirect ke halaman utama atau halaman yang diinginkan
        return redirect('/');
    }
}
