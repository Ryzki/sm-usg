<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Area;
use App\Models\MidwifeArea;
use App\Models\SubDistrict;
use App\Models\User;
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

        User::create([
            'full_name' => 'Pramusita Ayu Nabila',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 1,
        ]);

        User::create([
            'full_name' => 'Aning',
            'email' => 'bidan1@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 2,
        ]);

        User::create([
            'full_name' => 'Nuari',
            'email' => 'bidan2@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 2,
        ]);

        User::create([
            'full_name' => 'Ana',
            'email' => 'bidan3@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 2,
        ]);

        SubDistrict::create([
            'name' => 'Rowosari'
        ]);

        SubDistrict::create([
            'name' => 'Meteseh'
        ]);

        SubDistrict::create([
            'name' => 'Mangunharjo'
        ]);

        Area::create([
            'sub_district_id' => 1,
            'residential_association' => 1
        ]);

        Area::create([
            'sub_district_id' => 1,
            'residential_association' => 2
        ]);

        Area::create([
            'sub_district_id' => 1,
            'residential_association' => 3
        ]);

        Area::create([
            'sub_district_id' => 2,
            'residential_association' => 1
        ]);

        Area::create([
            'sub_district_id' => 2,
            'residential_association' => 2
        ]);

        Area::create([
            'sub_district_id' => 2,
            'residential_association' => 3
        ]);

        Area::create([
            'sub_district_id' => 3,
            'residential_association' => 1
        ]);

        Area::create([
            'sub_district_id' => 3,
            'residential_association' => 2
        ]);

        Area::create([
            'sub_district_id' => 3,
            'residential_association' => 3
        ]);

        // Bidan ANING index 2
        // Bidan NUARI index 3
        // Bidan ANA index 4

        MidwifeArea::create([
            'midwife_id' => 2,
            'area_id' => 1
        ]);

        MidwifeArea::create([
            'midwife_id' => 4,
            'area_id' => 2
        ]);

        MidwifeArea::create([
            'midwife_id' => 2,
            'area_id' => 3
        ]);

        MidwifeArea::create([
            'midwife_id' => 3,
            'area_id' => 4
        ]);

        MidwifeArea::create([
            'midwife_id' => 3,
            'area_id' => 5
        ]);

        MidwifeArea::create([
            'midwife_id' => 4,
            'area_id' => 6
        ]);

        MidwifeArea::create([
            'midwife_id' => 3,
            'area_id' => 7
        ]);

        MidwifeArea::create([
            'midwife_id' => 3,
            'area_id' => 8
        ]);

        MidwifeArea::create([
            'midwife_id' => 4,
            'area_id' => 9
        ]);
    }
}
