<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreventUnverifiedAccess
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $role = Auth::user()->role;

            if (!Auth::user()->verified) {
                return redirect()->route($role->verification_route);
            }
        }

        return $next($request);
    }
}
