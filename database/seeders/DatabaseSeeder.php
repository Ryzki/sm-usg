<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Area;
use App\Models\Role;
use App\Models\User;
use App\Models\Visit;
use App\Models\MidwifeArea;
use App\Models\SubDistrict;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\PreeclampsiaScreening;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        Visit::create([
            'name' => 'Kunjungan 1',
            'abbreviation' => 'K1',
            'category_trimester' => 1,
        ]);

        Visit::create([
            'name' => 'Kunjungan 2',
            'abbreviation' => 'K2',
            'category_trimester' => 2,
        ]);

        Visit::create([
            'name' => 'Kunjungan 3',
            'abbreviation' => 'K3',
            'category_trimester' => 2,
        ]);

        Visit::create([
            'name' => 'Kunjungan 4',
            'abbreviation' => 'K4',
            'category_trimester' => 3,
        ]);

        Visit::create([
            'name' => 'Kunjungan 5',
            'abbreviation' => 'K5',
            'category_trimester' => 3,
        ]);

        Visit::create([
            'name' => 'Kunjungan 6',
            'abbreviation' => 'K6',
            'category_trimester' => 3,
        ]);

        PreeclampsiaScreening::create([
            'screening_name' => 'Multipara dengan kehamilan oleh pasangan baru',
            'risk_category' => 1,
        ]);

        PreeclampsiaScreening::create([
            'screening_name' => 'Kehamilan dengan teknologi reproduksi berbantu: bayi tabung, obat induksi ovulasi',
            'risk_category' => 1,
        ]);

        PreeclampsiaScreening::create([
            'screening_name' => 'Umur >= 35 Tahun',
            'risk_category' => 1,
        ]);

        PreeclampsiaScreening::create([
            'screening_name' => 'Nulipara',
            'risk_category' => 1,
        ]);

        PreeclampsiaScreening::create([
            'screening_name' => 'Multipara yang jarak kehamilan sebelumnya > 10 Tahun',
            'risk_category' => 1,
        ]);

        PreeclampsiaScreening::create([
            'screening_name' => 'Riwayat preeklamsia pada ibu ataua saudara perempuan',
            'risk_category' => 1,
        ]);

        PreeclampsiaScreening::create([
            'screening_name' => 'Obesitas sebelum hamil (IMT > 30 kg/m2)',
            'risk_category' => 1,
        ]);

        PreeclampsiaScreening::create([
            'screening_name' => 'Multipara dengan riwayat preeklamsia sebelumnya',
            'risk_category' => 2,
        ]);

        PreeclampsiaScreening::create([
            'screening_name' => 'Kehamilan multipel',
            'risk_category' => 2,
        ]);

        PreeclampsiaScreening::create([
            'screening_name' => 'Diabetes dalam kehamilan',
            'risk_category' => 2,
        ]);

        PreeclampsiaScreening::create([
            'screening_name' => 'Hipertensi Kronik',
            'risk_category' => 2,
        ]);

        PreeclampsiaScreening::create([
            'screening_name' => 'Penyakit ginjal',
            'risk_category' => 2,
        ]);

        PreeclampsiaScreening::create([
            'screening_name' => 'Penyakit autoimun, SLE',
            'risk_category' => 2,
        ]);

        PreeclampsiaScreening::create([
            'screening_name' => 'Anti phospholipid syndrome',
            'risk_category' => 2,
        ]);

        PreeclampsiaScreening::create([
            'screening_name' => 'Mean Arterial Presure > 90 mmHg',
            'risk_category' => 1,
        ]);

        PreeclampsiaScreening::create([
            'screening_name' => 'Proteinuria (urin celup > +1 pada 2 kali pemeriksaaan berjarak 6 jam atau segera kuantitatif 300 mg/24 Jam)',
            'risk_category' => 1,
        ]);

        Role::create([
            'name' => 'Ibu Hamil',
            'verification_route' => 'verification',
            'dashboard_route' => 'user.dashboard'
        ]);

        Role::create([
            'name' => 'Bidan',
            'verification_route' => 'verification',
            'dashboard_route' => 'midwife.dashboard'
        ]);

        Role::create([
            'name' => 'Dokter',
            'verification_route' => 'verification',
            'dashboard_route' => 'doctor.dashboard'
        ]);

        Role::create([
            'name' => 'Admin',
            'dashboard_route' => 'admin.dashboard'
        ]);
    }
}
