<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\MidwifeArea;
use App\Models\SubDistrict;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('app.user.index');
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
                    'subdisctrict' => $request->input('sub_district'),
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
}
