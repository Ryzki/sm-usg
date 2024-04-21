<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientPreeclamsiaScreenings extends Model
{
    use HasFactory;

    protected $table = 'patient_preeclampsia_screenings';

    protected $fillable = ['code_history', 'preeclampsia_screenings_id'];

    public function history_anc()
    {
        return $this->belongsTo(HistoryANC::class, 'code_history', 'history_skrining_preklampsia_code');
    }
}
