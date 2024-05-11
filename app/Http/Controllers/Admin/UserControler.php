<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class UserControler extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::with('role')->whereNot('role_id', 4);

            return DataTables::eloquent($users)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    if ($data->verified == 0) {
                        return '
                            <div class="btn-list flex-nowrap text-center">
                                <a class="btn btn-icon btn-warning" id="btnModalChangeRole" data-role="' . $data->role_id . '" data-name="' . $data->full_name . '" data-id="' . $data->id . '" >
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-accessible"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M10 16.5l2 -3l2 3m-2 -3v-2l3 -1m-6 0l3 1" /><circle cx="12" cy="7.5" r=".5" fill="currentColor" /></svg>
                                </a>
                            </div>
                        ';
                    } else {
                        return '-';
                    }
                })
                ->editColumn('phone_number', function ($data) {
                    if ($data->phone_number !== null) {
                        return $data->formatted_phone;
                    } else {
                        return '-';
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $roles = Role::whereNot('id', 4)->get();
        return view('app.admin.users', [
            'roles' => $roles
        ]);
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->only(['full_name', 'email', 'password', 'role']), [
            'full_name' => 'required|string',
            'email' => 'required|email:dns|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:' . implode(',', Role::pluck('id')->toArray())
        ], [
            'full_name.required' => 'Nama lengkap harus diisi.',
            'email.required' => 'Alamat email harus diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Alamat email sudah digunakan.',
            'password.required' => 'Kata sandi harus diisi.',
            'password.min' => 'Kata sandi minimal harus :min karakter.',
            'role.required' => 'Role harus diisi.',
            'role.in' => 'Role tidak valid.'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validated->errors()
            ], 422);
        }

        $user = User::create([
            'full_name' => $request->input('full_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role_id' => $request->input('role'),
        ]);

        if ($user) {
            return response()->json([
                'status' => true,
                'message' => 'Pengguna berhasil dibuat'
            ], 200);
        }

        return response()->json([
            'status' => true,
            'message' => 'Pengguna gagal dibuat'
        ], 200);
    }

    public function changeRole(Request $request)
    {
        $validated = Validator::make($request->only('id', 'role'), [
            'id' => 'required',
            'role' => 'required'
        ], [
            'id.required' => 'Nama wajib harus diisi.',
            'role.required' => 'Role wajib harus diisi.',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validated->errors()
            ], 400);
        }

        $user = User::find($request->input('id'));

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Pengguna tidak ditemukan'
            ], 404);
        }

        $user->update([
            'role_id' => $request->input('role')
        ]);

        if ($user->wasChanged()) {
            return response()->json([
                'status' => true,
                'message' => 'Role berhasil terupdate'
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Role gagal terupdate'
        ], 200);
    }
}
