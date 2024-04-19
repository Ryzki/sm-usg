<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Area;
use App\Models\MidwifeArea;
use App\Models\PreeclampsiaScreening;
use App\Models\SubDistrict;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // User::create([
        //     'full_name' => 'Pramusita Ayu Nabila',
        //     'email' => 'user@gmail.com',
        //     'password' => Hash::make('password'),
        //     'role_id' => 1,
        // ]);

        // User::create([
        //     'full_name' => 'Aning',
        //     'email' => 'bidan1@gmail.com',
        //     'password' => Hash::make('password'),
        //     'role_id' => 2,
        // ]);

        // User::create([
        //     'full_name' => 'Nuari',
        //     'email' => 'bidan2@gmail.com',
        //     'password' => Hash::make('password'),
        //     'role_id' => 2,
        // ]);

        // User::create([
        //     'full_name' => 'Ana',
        //     'email' => 'bidan3@gmail.com',
        //     'password' => Hash::make('password'),
        //     'role_id' => 2,
        // ]);

        // SubDistrict::create([
        //     'name' => 'Rowosari'
        // ]);

        // SubDistrict::create([
        //     'name' => 'Meteseh'
        // ]);

        // SubDistrict::create([
        //     'name' => 'Mangunharjo'
        // ]);

        // Area::create([
        //     'sub_district_id' => 1,
        //     'residential_association' => 1
        // ]);

        // Area::create([
        //     'sub_district_id' => 1,
        //     'residential_association' => 2
        // ]);

        // Area::create([
        //     'sub_district_id' => 1,
        //     'residential_association' => 3
        // ]);

        // Area::create([
        //     'sub_district_id' => 2,
        //     'residential_association' => 1
        // ]);

        // Area::create([
        //     'sub_district_id' => 2,
        //     'residential_association' => 2
        // ]);

        // Area::create([
        //     'sub_district_id' => 2,
        //     'residential_association' => 3
        // ]);

        // Area::create([
        //     'sub_district_id' => 3,
        //     'residential_association' => 1
        // ]);

        // Area::create([
        //     'sub_district_id' => 3,
        //     'residential_association' => 2
        // ]);

        // Area::create([
        //     'sub_district_id' => 3,
        //     'residential_association' => 3
        // ]);

        // Bidan ANING index 2
        // Bidan NUARI index 3
        // Bidan ANA index 4

        // MidwifeArea::create([
        //     'midwife_id' => 2,
        //     'area_id' => 1
        // ]);

        // MidwifeArea::create([
        //     'midwife_id' => 4,
        //     'area_id' => 2
        // ]);

        // MidwifeArea::create([
        //     'midwife_id' => 2,
        //     'area_id' => 3
        // ]);

        // MidwifeArea::create([
        //     'midwife_id' => 3,
        //     'area_id' => 4
        // ]);

        // MidwifeArea::create([
        //     'midwife_id' => 3,
        //     'area_id' => 5
        // ]);

        // MidwifeArea::create([
        //     'midwife_id' => 4,
        //     'area_id' => 6
        // ]);

        // MidwifeArea::create([
        //     'midwife_id' => 3,
        //     'area_id' => 7
        // ]);

        // MidwifeArea::create([
        //     'midwife_id' => 3,
        //     'area_id' => 8
        // ]);

        // MidwifeArea::create([
        //     'midwife_id' => 4,
        //     'area_id' => 9
        // ]);

        // Visit::create([
        //     'name' => 'Kunjungan 1',
        //     'abbreviation' => 'K1',
        //     'category_trimester' => 1,
        // ]);

        // Visit::create([
        //     'name' => 'Kunjungan 2',
        //     'abbreviation' => 'K2',
        //     'category_trimester' => 2,
        // ]);

        // Visit::create([
        //     'name' => 'Kunjungan 3',
        //     'abbreviation' => 'K3',
        //     'category_trimester' => 2,
        // ]);

        // Visit::create([
        //     'name' => 'Kunjungan 4',
        //     'abbreviation' => 'K4',
        //     'category_trimester' => 3,
        // ]);

        // Visit::create([
        //     'name' => 'Kunjungan 5',
        //     'abbreviation' => 'K5',
        //     'category_trimester' => 3,
        // ]);

        // Visit::create([
        //     'name' => 'Kunjungan 6',
        //     'abbreviation' => 'K6',
        //     'category_trimester' => 3,
        // ]);

        // PreeclampsiaScreening::create([
        //     'screening_name' => 'Multipara dengan kehamilan oleh pasangan baru',
        //     'risk_category' => 1,
        // ]);

        // PreeclampsiaScreening::create([
        //     'screening_name' => 'Kehamilan dengan teknologi reproduksi berbantu: bayi tabung, obat induksi ovulasi',
        //     'risk_category' => 1,
        // ]);

        // PreeclampsiaScreening::create([
        //     'screening_name' => 'Umur >= 35 Tahun',
        //     'risk_category' => 1,
        // ]);

        // PreeclampsiaScreening::create([
        //     'screening_name' => 'Nulipara',
        //     'risk_category' => 1,
        // ]);

        // PreeclampsiaScreening::create([
        //     'screening_name' => 'Multipara yang jarak kehamilan sebelumnya > 10 Tahun',
        //     'risk_category' => 1,
        // ]);

        // PreeclampsiaScreening::create([
        //     'screening_name' => 'Riwayat preeklamsia pada ibu ataua saudara perempuan',
        //     'risk_category' => 1,
        // ]);

        // PreeclampsiaScreening::create([
        //     'screening_name' => 'Obesitas sebelum hamil (IMT > 30 kg/m2)',
        //     'risk_category' => 1,
        // ]);

        // PreeclampsiaScreening::create([
        //     'screening_name' => 'Multipara dengan riwayat preeklamsia sebelumnya',
        //     'risk_category' => 2,
        // ]);

        // PreeclampsiaScreening::create([
        //     'screening_name' => 'Kehamilan multipel',
        //     'risk_category' => 2,
        // ]);

        // PreeclampsiaScreening::create([
        //     'screening_name' => 'Diabetes dalam kehamilan',
        //     'risk_category' => 2,
        // ]);

        // PreeclampsiaScreening::create([
        //     'screening_name' => 'Hipertensi Kronik',
        //     'risk_category' => 2,
        // ]);

        // PreeclampsiaScreening::create([
        //     'screening_name' => 'Penyakit ginjal',
        //     'risk_category' => 2,
        // ]);

        // PreeclampsiaScreening::create([
        //     'screening_name' => 'Penyakit autoimun, SLE',
        //     'risk_category' => 2,
        // ]);

        // PreeclampsiaScreening::create([
        //     'screening_name' => 'Anti phospholipid syndrome',
        //     'risk_category' => 2,
        // ]);

        // PreeclampsiaScreening::create([
        //     'screening_name' => 'Mean Arterial Presure > 90 mmHg',
        //     'risk_category' => 1,
        // ]);

        // PreeclampsiaScreening::create([
        //     'screening_name' => 'Proteinuria (urin celup > +1 pada 2 kali pemeriksaaan berjarak 6 jam atau segera kuantitatif 300 mg/24 Jam)',
        //     'risk_category' => 1,
        // ]);
    }
}
