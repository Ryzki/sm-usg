<?php

namespace App\Http\Controllers\Midwife;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\ScheduleANC;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $midwife = User::find(Auth::user()->id);
        $countUser = User::where('midwife_id', Auth::user()->id)->count();

        return view('app.midwife.index', compact('midwife', 'countUser'));
    }

    public function getScheduleUser(Request $request)
    {
        $scheduleUser = ScheduleANC::with('visit')->where('user_id', $request->input('id'))->get();

        return response()->json($scheduleUser);
    }
}
