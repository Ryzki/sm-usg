<?php

namespace App\Helpers;

use Carbon\Carbon;

class MyHelper
{
    public static function hitungUsiaKehamilan($tanggalTerakhirHaid)
    {
        // Hitung usia kehamilan dari tanggal terakhir haid
        $tanggalTerakhirHaid = Carbon::createFromFormat('Y-m-d', $tanggalTerakhirHaid);
        $tanggalSaatIni = Carbon::now();

        // Hitung selisih dalam minggu dan hari
        $usiaMinggu = $tanggalTerakhirHaid->diffInWeeks($tanggalSaatIni);
        $usiaHari = $tanggalTerakhirHaid->diffInDays($tanggalSaatIni) % 7;

        return [
            'minggu' => $usiaMinggu,
            'hari' => $usiaHari
        ];
    }
    // public static function hitungUsiaJanin($hpht)
    // {
    //     // Tanggal pertama hari terakhir menstruasi
    //     $tanggalHPHT = Carbon::createFromFormat('Y-m-d', $hpht);

    //     // Tanggal saat ini
    //     $tanggalSaatIni = Carbon::now();

    //     // Hitung selisih dalam minggu dan hari
    //     $usiaJaninMinggu = $tanggalHPHT->diffInWeeks($tanggalSaatIni);
    //     $usiaJaninHari = $tanggalHPHT->diffInDays($tanggalSaatIni) % 7;

    //     return "$usiaJaninMinggu Minggu, $usiaJaninHari Hari";
    // }

    // public static function calculateGestationalAge($lastPeriodDate)
    // {
    //     // Hitung usia kehamilan dari tanggal terakhir haid
    //     $lastPeriod = Carbon::createFromFormat('Y-m-d', $lastPeriodDate);
    //     $currentDate = Carbon::now();
    //     $gestationalAge = $lastPeriod->diffInWeeks($currentDate);

    //     // Kembalikan true jika usia kehamilan lebih dari atau sama dengan 16 minggu, jika tidak kembalikan false
    //     return $gestationalAge >= 16;
    // }
}
