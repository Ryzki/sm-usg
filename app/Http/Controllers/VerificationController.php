<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\SubDistrict;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    public function index()
    {
        $user = User::findOrFail(Auth::user()->id);
        $subDistricts = SubDistrict::all();
        return view('app.verification', compact('user', 'subDistricts'));
    }

    public function postVerification(Request $request)
    {
        $rules = [
            'nik' => 'required|min:16|max:16',
            'full_name' => 'required',
            'email' => 'required|email:dns',
            'place_of_birth' => 'required',
            'date_of_birth' => 'required',
            'phone_number' => 'required|min:10|max:13|regex:/^08\d{8,11}$/',
            'home_address' => 'required',
            'NA' => 'required',
            'RA' => 'required',
            'district' => 'required',
            'city' => 'required',
        ];

        $messages = [
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
            'phone_number.regex' => 'Nomor Telepon harus dimulai dengan angka 08 dan diikuti oleh 10 hingga 12 digit angka.',
            'home_address.required' => 'Alamat Rumah harus diisi.',
            'NA.required' => 'RT harus diisi.',
            'RA.required' => 'RW harus diisi.',
            'district.required' => 'Kota/kabupaten harus diisi.',
            'city.required' => 'Kota harus diisi.',
            'midwife.required' => 'Bidan harus diisi.'
        ];

        if (Auth::user()->role_id == 1) {
            $rules['sub_district'] = ['required', Rule::in(SubDistrict::pluck('name')->toArray())];
            $rules['midwife'] = 'required';

            $messages['sub_district.required'] = 'Kecamatan harus diisi.';
            $messages['sub_district.in'] = 'Kecamatan yang dipilih tidak valid';
        } else {
            $rules['sub_district'] = 'required';
            $messages['sub_district.required'] = 'Kecamatan harus diisi.';
        }

        $request->validate($rules, $messages);

        try {
            DB::beginTransaction();

            if ($request->has('id')) {
                $idUser = $request->input('id');

                $dataUser = [
                    'full_name' => $request->input('full_name'),
                    'email' => $request->input('email'),
                    'verified' => true,
                    'nik' => $request->input('nik'),
                    'phone_number' => '62' . ltrim($request->input('phone_number'), '0'),
                    'home_address' =>  $request->input('home_address'),
                    'place_of_birth' => $request->input('place_of_birth'),
                    'date_of_birth' => Carbon::createFromFormat('d-m-Y', $request->input('date_of_birth'))->format('Y-m-d'),
                    'NA' => $request->input('NA'),
                    'RA' => $request->input('RA'),
                    'subdistrict' => $request->input('sub_district'),
                    'district' => $request->input('district'),
                    'city' => $request->input('city'),
                    'midwife_id' => Auth::user()->role_id == 1 ? $request->input('midwife') : null
                ];

                $user = User::find($idUser);
                $user->update($dataUser);

                $updatedUser = User::with('role')->find($idUser);

                DB::commit();

                Auth::login($updatedUser);

                return redirect()
                    ->route($updatedUser->role->dashboard_route)
                    ->with('success', 'Akun anda sudah Terverifikasi. Terima Kasih');
            } else {
                return redirect()->back()->with('message', 'Tidak ada ID pengguna yang disediakan.');
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()
                ->route('verification')
                ->with('message', $th->getMessage());
        }
    }
}
