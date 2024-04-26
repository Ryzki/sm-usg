<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreeclampsiaScreening extends Model
{
    use HasFactory;

    protected $table = 'preeclampsia_screenings';

    public function patientPreeclampsiaScreenings()
    {
        return $this->hasMany(PatientPreeclamsiaScreenings::class);
    }
}
