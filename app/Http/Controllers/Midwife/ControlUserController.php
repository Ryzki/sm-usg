<?php

namespace App\Http\Controllers\Midwife;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ControlUserController extends Controller
{

    public function index(Request $request)
    {
        $query = User::with(['scheduleAncs', 'latestHistoryAncs'])
            ->where('midwife_id', Auth::user()->id);

        if ($request->has('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', '%' . $search . '%')
                    ->orWhere('nik', 'like', '%' . $search . '%');
            });
        }

        $users = $query->paginate(5);

        return view('app.midwife.control-user', [
            'users' => $users
        ]);
    }


    public function create()
    {
    }


    public function store(Request $request)
    {
    }


    public function show($id)
    {
    }


    public function edit($id)
    {
    }


    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
