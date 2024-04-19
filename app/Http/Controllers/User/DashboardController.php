<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\MidwifeArea;
use App\Models\SubDistrict;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\PregnancyHistory;
use App\Models\ScheduleANC;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function index()
    {
        $idUser = Auth::user()->id;

        $user =  User::with('midwife')->find($idUser);
        $pregnantHistory = PregnancyHistory::where('pregnant_mother_id', $idUser)
            ->where('status', 1)
            ->latest()
            ->first();

        $scheduleUser = ScheduleANC::with(['user', 'visit'])
            ->where('user_id', $user->id)
            ->whereDate('schedule_date', now()->toDateString())
            ->where('status', false)
            ->first();

        if ($pregnantHistory->exists()) {
            $countDown = $this->calculateDeliveryCountdown($pregnantHistory->estimated_due_date);
            $pregnantHistoryFormatted = Carbon::createFromFormat('Y-m-d', $pregnantHistory->estimated_due_date)
                ->translatedFormat('d F Y');
            return view('app.user.index', compact('user', 'pregnantHistoryFormatted', 'countDown', 'scheduleUser'));
        }

        return view('app.user.index', compact('user'));
    }

    public function verified(Request $request)
    {
        if ($request->input()) {
            $validateUser = $request->validate([
                'nik' => 'required|min:16',
                'full_name' => 'required',
                'email' => 'required|email:dns',
                'place_of_birth' => 'required',
                'date_of_birth' => 'required',
                'phone_number' => 'required|min:10|max:13|regex:/^8\d{10,12}$/',
                'home_address' => 'required',
                'NA' => 'required',
                'RA' => 'required',
                'sub_district' => ['required', Rule::in(SubDistrict::pluck('name')->toArray())],
                'district' => 'required',
                'city' => 'required',
                'midwife' => 'required'
            ], [
                'nik.required' => 'NIK harus diisi.',
                'nik.min' => 'NIK harus memiliki panjang minimal :min karakter.',
                'nik.max' => 'NIK harus memiliki panjang maksimal :max karakter.',
                'full_name.required' => 'Nama lengkap harus diisi.',
                'email.required' => 'Alamat email harus diisi.',
                'email.email' => 'Alamat email harus valid.',
                'place_of_birth.required' => 'Tempat lahir harus diisi.',
                'date_of_birth.required' => 'Tanggal lahir harus diisi.',
                'phone_number.required' => 'Nomor Telepon harus diisi.',
                'phone_number.min' => 'Nomor Telepon harus memiliki panjang minimal :min karakter.',
                'phone_number.max' => 'Nomor Telepon harus memiliki panjang maksimal :max karakter.',
                'phone_number.regex' => 'Nomor Telepon harus dimulai dengan angka 8 dan diikuti oleh 10 hingga 12 digit angka.',
                'home_address.required' => 'Alamat Rumah harus diisi.',
                'NA.required' => 'RT harus diisi.',
                'RA.required' => 'RW harus diisi.',
                'sub_district.required' => 'Kecamatan harus diisi.',
                'sub_district.in' => 'Kecamatan yang dipilih tidak valid',
                'district.required' => 'Kota/kabupaten harus diisi.',
                'city.required' => 'Kota harus diisi.',
                'midwife.required' => 'Bidan harus diisi.'
            ]);

            if ($request->input('id')) {
                $idUser = $request->input('id');

                $dataUser = [
                    'full_name' => $request->input('full_name'),
                    'email' => $request->input('email'),
                    'verified' => true,
                    'nik' => $request->input('nik'),
                    'phone_number' => '62' . $request->input('phone_number'),
                    'home_address' =>  $request->input('home_address'),
                    'place_of_birth' => $request->input('place_of_birth'),
                    'date_of_birth' => Carbon::createFromFormat('d-m-Y', $request->input('date_of_birth'))->format('Y-m-d'),
                    'NA' => $request->input('NA'),
                    'RA' => $request->input('RA'),
                    'subdistrict' => $request->input('sub_district'),
                    'district' => $request->input('district'),
                    'city' => $request->input('city'),
                    'midwife_id' => $request->input('midwife'),
                ];

                $user = User::findOrFail($idUser);
                $user->update($dataUser);

                // Ambil kembali data pengguna yang diperbarui dari database
                $updatedUser = User::findOrFail($idUser);

                // Simpan data pengguna yang diperbarui ke dalam sesi dengan mengganti objek Auth::user() dengan data pengguna yang baru
                Auth::login($updatedUser);

                return redirect()->route('user.dashboard')->with('success', 'Akun anda sudah Terverifikasi. Terima Kasih');
            }
        }
        $user = User::findOrFail(Auth::user()->id);
        $subDistricts = SubDistrict::all();
        return view('app.user.verification', compact('user', 'subDistricts'));
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

    private function calculateDeliveryCountdown($date)
    {
        // Date of the expected delivery
        $deliveryDate = Carbon::createFromFormat('Y-m-d', $date);

        // Current date
        $currentDate = Carbon::now();

        // Calculating the difference in days between the current date and the delivery date
        $difference = $deliveryDate->diffInDays($currentDate);

        // Calculating the number of weeks
        $weeks = floor($difference / 7);

        // Calculating the remaining days after being calculated in weeks
        $remainingDays = $difference % 7;

        // Returning the result
        return "$weeks Minggu, $remainingDays Hari";
    }
}
