<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Periksa apakah pengguna terverifikasi
            if ($user->verified) {
                // Periksa apakah peran pengguna sesuai dengan salah satu dari peran yang diizinkan
                if (in_array($user->role->name, $roles)) {
                    return $next($request);
                } else {
                    // Jika peran pengguna tidak sesuai, kembalikan response tidak diizinkan
                    return redirect()->route($user->role->dashboard_route);
                }
            } else {
                // Pengguna tidak terverifikasi, alihkan ke rute verifikasi
                return redirect()->route($user->role->verification_route);
            }
        }

        // Jika pengguna tidak terotentikasi, alihkan ke halaman login
        return redirect()->route('login');

        // // Periksa apakah pengguna terotentikasi dan terverifikasi
        // if (Auth::check() && Auth::user()->verified) {
        //     // Periksa apakah peran pengguna sesuai dengan salah satu dari peran yang diizinkan
        //     if (in_array(Auth::user()->role->name, $roles)) {
        //         return $next($request);
        //     }
        // } else {
        //     return redirect()->route(Auth::user()->role->verification_route);
        // }

        // // Jika peran pengguna tidak sesuai, kembalikan response tidak diizinkan
        // return redirect()->route(Auth::user()->role->dashboard_route);
    }
}
