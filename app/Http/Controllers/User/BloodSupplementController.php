<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\BloodSupplement;
use App\Models\PregnancyHistory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BloodSupplementController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $events = BloodSupplement::where('pregnant_mother_id', Auth::user()->id)
                ->where('start_end', '>=', $request->only('start'))
                ->where('start_end', '<=', $request->only('end'))
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diambil',
                'datas' => $events
            ], 200);
        }

        $permissionBloodSupplement = $this->checkTTD(Auth::user()->id);

        return view('app.user.schedule-supplement', compact('permissionBloodSupplement'));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->only('date'), [
            'date' => 'required'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validated->errors()
            ], 400);
        }

        $isAlreadyAbsent = BloodSupplement::where('start_end', $request->input('date'))
            ->where(function ($query) {
                $query->where('pregnant_mother_id', Auth::user()->id);
            })
            ->exists();

        if ($isAlreadyAbsent) {
            return response()->json([
                'status' => false,
                'message' => 'Anda sudah minum obat hari ini'
            ], 200);
        }

        $bloodSupplement = BloodSupplement::create([
            'pregnant_mother_id' => Auth::user()->id,
            'start_end' => $request->input('date'),
            'status' => 1
        ]);

        if ($bloodSupplement) {
            return response()->json([
                'status' => true,
                'message' => 'Absen Berhasil'
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Absen Gagal!'
        ], 200);
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

    public function checkTTD($pregnantMotherId)
    {
        // Temukan data ibu hamil berdasarkan ID
        $pregnantMother = PregnancyHistory::find($pregnantMotherId);

        if (!$pregnantMother) {
            // Jika data ibu hamil tidak ditemukan, kembalikan pesan error
            return false;
        }

        // Hitung usia kehamilan dari tanggal perkiraan lahir (EDD) dan tanggal hari ini
        $estimatedDueDate = Carbon::parse($pregnantMother->estimated_due_date);
        $weeksPregnant = Carbon::now()->diffInWeeks($estimatedDueDate);

        // Periksa apakah usia kehamilan kurang dari 16 minggu
        if ($weeksPregnant < 16) {
            // Jika kurang dari 16 minggu, berikan rekomendasi minum TTD
            return true;
        } else {
            // Jika tidak kurang dari 16 minggu, berikan pesan bahwa tidak perlu minum TTD
            return false;
        }
    }
}
