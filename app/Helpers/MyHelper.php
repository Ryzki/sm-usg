<?php

namespace App\Helpers;

use Carbon\Carbon;

class MyHelper
{
    public static function calculateGestationalAge($lastPeriodDate)
    {
        // Hitung usia kehamilan dari tanggal terakhir haid
        $lastPeriod = Carbon::createFromFormat('Y-m-d', $lastPeriodDate);
        $currentDate = Carbon::now();
        $gestationalAge = $lastPeriod->diffInWeeks($currentDate);

        // Kembalikan true jika usia kehamilan lebih dari atau sama dengan 16 minggu, jika tidak kembalikan false
        return $gestationalAge >= 16;
    }
}
