<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AllowVerifiedAccess
{
    public function handle(Request $request, Closure $next)
    {
        // Periksa apakah pengguna telah diverifikasi
        if (Auth::check() && Auth::user()->verified) {
            // Ambil prefix yang diharapkan berdasarkan peran pengguna
            $rolePrefix = explode('.', Auth::user()->role->verification_route);
            $path = explode('/', $request->path());
            // dd($request->path(), $rolePrefix);
            // dd(!str_starts_with($path[0], $rolePrefix[0]));

            // Jika pengguna telah diverifikasi, tetapi mencoba mengakses prefix diluar '/user/', '/midwife/', atau '/doctor/', tolak akses
            if (!str_starts_with($path[0], $rolePrefix[0])) {
                abort(403, 'Unauthorized');
            }
        }

        return $next($request);
    }
}
