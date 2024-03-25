<?php

namespace App\Http\Controllers\Auth;

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
            $request->session()->regenerate();

            $url = route('user.dashboard');

            if (!Auth::user()->verified) {
                $url = route('user.verified');
            }

            return response()->json([
                'status' => true,
                'data' => $url,
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
