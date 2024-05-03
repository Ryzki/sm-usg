<?php

namespace App\Http\Controllers\Doctor;

use App\Models\User;
use App\Models\ScheduleANC;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $countUsers = User::where('role_id', 1)->count();
        return view('app.doctor.index', compact('countUsers'));
    }

    public function controlAllUsers(Request $request)
    {
        $query = User::with(['scheduleAncs', 'latestHistoryAncs'])
            ->where('role_id', 1);

        if ($request->has('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', '%' . $search . '%')
                    ->orWhere('nik', 'like', '%' . $search . '%');
            });
        }

        $users = $query->paginate(5);

        return view('app.doctor.control-all-user', [
            'users' => $users
        ]);
    }

    public function getScheduleUser(Request $request)
    {
        $scheduleUser = ScheduleANC::with('visit')->where('user_id', $request->input('id'))->get();

        return response()->json($scheduleUser);
    }
}
