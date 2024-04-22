<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryANC extends Model
{
    use HasFactory;

    protected $table = 'history_ancs';

    protected $fillable = [
        'user_id', 'visit_id', 'inspection_date', 'age', 'gestational_age', 'weight', 'height', 'lila', 'sistolik', 'diastolik', 'hemoglobin_level', 'usg_img', 'stat_skrining_preklampsia', 'history_skrining_preklampsia_code', 'note'
    ];

    public function patient_preeclamsia_screenings()
    {
        return $this->hasMany(PatientPreeclamsiaScreenings::class, 'history_skrining_preklampsia_code', 'code_history');
    }

    public function getStatSkriningPreklampsiaLabelAttribute()
    {
        switch ($this->stat_skrining_preklampsia) {
            case 1:
                return 'Resiko Rendah';
                break;
            case 2:
                return 'Resiko Sedang';
                break;
            case 3:
                return 'Resiko Tinggi';
                break;
            default:
                return '';
        }
    }
}
