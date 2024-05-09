<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MidwifeArea;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userVerified = User::where('verified', 1)->count();
        $userUnverified = User::where('verified', 0)->count();
        $areas = MidwifeArea::count();

        return view('app.admin.index', compact('userVerified', 'userUnverified', 'areas'));
    }
}
