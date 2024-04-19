<?php

namespace App\Http\Controllers\Auth;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->only(['email', 'password']), [
            'email' => 'required|email:dns',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $role = Role::find($user->role_id);

            // Periksa apakah akun pengguna belum diverifikasi
            if (!$user->verified) {
                return response()->json([
                    'status' => true,
                    'message' => 'Akun Anda belum diverifikasi.',
                    'url' => route($role->verification_route)
                ], 200);
            }

            // Alihkan ke rute dashboard yang sesuai dengan peran pengguna
            return response()->json([
                'status' => true,
                'url' => route($role->dashboard_route),
                'message' => 'Login Berhasil',
            ], 200);
        }

        return  response()->json([
            'status' => false,
            'message' => 'Email atau password anda salah!!',
        ], 200);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
