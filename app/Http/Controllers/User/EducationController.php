<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EducationController extends Controller
{

    public function index()
    {
        return view('app.user.education.index');
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
        if ($id == 1) {
            $title = 'Pemeriksaan Kehamilan';
            $url = asset('assets/main/file/img/materi_ibu_hamil/1_Periksa_Kehamilan.jpg');
            return view('app.user.education.show', compact('url', 'title'));
        } elseif ($id == 2) {
            $title = 'Perawatan Sehari Hari untuk Ibu Hamil';
            $url = asset('assets/main/file/img/materi_ibu_hamil/2_Perawatan_Sehari_Hari_Ibu_Hamil.jpg');
            return view('app.user.education.show', compact('url', 'title'));
        } elseif ($id == 3) {
            $title = 'Porsi Makan dan Minum untuk Kebutuhan Sehari';
            $url = asset('assets/main/file/img/materi_ibu_hamil/3_Porsi_Makan_dan_Minum_Ibu_Hamil.jpg');
            return view('app.user.education.show', compact('url', 'title'));
        } elseif ($id == 4) {
            $title = 'Tanda Bahaya dan Masalah lain pada Ibu Hamil';
            $url = asset('assets/main/file/img/materi_ibu_hamil/4_Tanda_Bahaya_pada_Kehamilan.jpg');
            return view('app.user.education.show', compact('url', 'title'));
        } elseif ($id == 5) {
            $title = ' Persiapan Melahirkan (Bersalin)';
            $url = asset('assets/main/file/img/materi_ibu_hamil/5_Persiapan_Melahirkan.jpg');
            return view('app.user.education.show', compact('url', 'title'));
        } else {
            return redirect()->route('user.education.index');
        }
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
