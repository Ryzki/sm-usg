<?php

namespace App\Http\Controllers\User;

use App\Helpers\MyHelper;
use Carbon\Carbon;
use App\Models\User;
use App\Models\HistoryANC;
use App\Models\MidwifeArea;
use App\Models\ScheduleANC;
use Illuminate\Http\Request;
use App\Models\PregnancyHistory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function index()
    {
        $idUser = Auth::user()->id;

        $user =  User::with('midwife')->find($idUser);
        // Mengambil data di Table PregnancyHistory apakah sudah di set apa belum
        $pregnantHistory = PregnancyHistory::where('pregnant_mother_id', $idUser)
            ->where('status', 1)
            ->latest()
            ->first();

        // Mengambil apakah ada Jadwal Kunjungan ANC yang tersedia di Hari ini
        $scheduleUser = ScheduleANC::with(['visit'])
            ->where('user_id', $user->id)
            ->whereDate('schedule_date', now()->toDateString())
            ->first();

        // Kondisi Status Ibu Hamil
        $conditionUser = HistoryANC::where('user_id', $user->id)
            ->latest()
            ->first();

        $permissionBloodSupplement = false;

        // Cek apakah ada terdapat Resiko di Ibu Hamil
        if (empty($conditionUser)) {
            // Jika tidak ada, maka Kondisi User itu Sehat atau di SET nilainya 0
            $conditionUser = 0;
        }

        if ($pregnantHistory) {
            $usiaKehamilan = MyHelper::hitungUsiaKehamilan($pregnantHistory->last_period_date);

            $gestationalAge = $usiaKehamilan['minggu'] . ' Minggu, ' . $usiaKehamilan['hari'] . ' Hari';
            $permissionBloodSupplement = $usiaKehamilan['minggu'] >= 16;

            $pregnantHistoryFormatted = Carbon::createFromFormat('Y-m-d', $pregnantHistory->estimated_due_date)->translatedFormat('d F Y');

            return view('app.user.index', compact(
                'user',
                'pregnantHistoryFormatted',
                'gestationalAge',
                'conditionUser',
                'scheduleUser',
                'permissionBloodSupplement'
            ));
        }

        return view('app.user.index', compact('user', 'conditionUser', 'scheduleUser', 'permissionBloodSupplement'));
    }

    public function getBidan(Request $request)
    {
        $user = MidwifeArea::with(['user', 'areas.subdistrict'])
            ->whereHas('areas.subdistrict', function ($query) use ($request) {
                $query->where('id', $request->input('subDistrict'));
            })
            ->whereHas('areas', function ($query) use ($request) {
                $query->where('residential_association', $request->input('NA'));
            })
            ->first();

        if ($user) {
            return response()->json([
                'status' => true,
                'message' => 'Bidan tersedia',
                'data' => $user->user
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Bidan Tidak Tersedia'
        ], 200);
    }

    public function createPregnancyHistory(Request $request)
    {
        $validated = Validator::make($request->only('setHPHT', 'estimatedDue'), [
            'setHPHT' => 'required',
            'estimatedDue' => 'required'
        ], [
            'setHPHT.required' => 'HPHT wajib diisi',
            'estimatedDue.required' => 'Hari Perkiraan Lahir wajib diisi'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validated->errors()
            ], 400);
        }

        $pregnancyHistory = PregnancyHistory::create([
            'pregnant_mother_id' => $request->input('idUser'),
            'last_period_date' => Carbon::createFromFormat('d-m-Y', $request->input('setHPHT'))->format('Y-m-d'),
            'estimated_due_date' => Carbon::createFromFormat('d-m-Y', $request->input('estimatedDue'))->format('Y-m-d'),
            'status' => 1
        ]);

        if ($pregnancyHistory) {
            return response()->json([
                'status' => true,
                'message' => 'HPHT berhasil diset'
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'HPHT gagal diset'
        ], 200);
    }
}
