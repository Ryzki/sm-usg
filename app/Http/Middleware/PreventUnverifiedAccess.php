<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreventUnverifiedAccess
{
    public function handle(Request $request, Closure $next)
    {
        // Periksa apakah pengguna telah diverifikasi
        if (Auth::check() && Auth::user()->verified) {
            $role = Auth::user()->role;
            $rolePrefix = '/' . $role[0] . '/';
            // Jika pengguna telah diverifikasi dan mencoba mengakses route 'verified', kembalikan mereka ke halaman dashboard
            if ($request->route()->named($role->verification_route) || !str_starts_with($request->path(), $rolePrefix)) {
                return redirect()->route($role->dashboard_route);
            }
        }

        return $next($request);
    }
}
