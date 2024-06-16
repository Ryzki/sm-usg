<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DynamicPrefix
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if ($user) {
            switch ($user->role_id) {
                case 2:
                    $prefix = 'midwife';
                    break;
                case 3:
                    $prefix = 'doctor';
                    break;
                case 4:
                    $prefix = 'admin';
                    break;
                default:
                    $prefix = 'default';
                    break;
            }

            $request->route()->setPrefix($prefix);
        }

        return $next($request);
    }
}
