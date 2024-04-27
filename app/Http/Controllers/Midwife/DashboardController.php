<?php

namespace App\Http\Controllers\Midwife;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('app.midwife.index');
    }
}
