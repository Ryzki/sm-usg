<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{

    public function index()
    {
        $user = User::find(Auth::user()->id);
        $midwife = User::where('id', $user->midwife_id)->first();
        $doctors = User::where('role_id', 3)->get();

        return view('app.user.chat', compact('midwife', 'doctors'));
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
