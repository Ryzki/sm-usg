<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{
    public function index()
    {
        return view('auth.registration');
    }

    public function registration(Request $request)
    {
        $validator = Validator::make($request->only(['full_name', 'email', 'password', 'password_confirmation']), [
            'full_name' => 'required|string',
            'email' => 'required|email:dns|unique:users,email',
            'password' => 'required|confirmed|min:6'
        ], [
            'full_name.required' => 'nama lengkap harus diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 1,
        ]);

        if ($user) {
            return response()->json([
                'status' => 'success',
                'message' => 'Akun sudah berhasil tersimpan',
                'data' => []
            ], 200);
        }

        return response()->json([
            'status' => 'failed',
            'message' => 'Akun gagal tersimpan',
            'data' => []
        ], 401);
    }
}
