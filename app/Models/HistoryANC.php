<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryANC extends Model
{
    use HasFactory;

    protected $table = 'history_ancs';

    protected $fillable = [
        'user_id', 'visit_id', 'inspection_date', 'age', 'gestational_age', 'weight', 'height', 'lila', 'sistolik', 'diastolik', 'hemoglobin_level', 'tetanus_toxoid', 'fetal_position', 'fetal_heartbeat', 'stat_risk_pregnancy_of_ced', 'stat_risk_preeclamsia', 'stat_risk_anemia', 'usg_img', 'stat_skrining_preklampsia', 'history_skrining_preklampsia_code', 'note'
    ];

    public function listPreclamsiaScreen()
    {
        return $this->hasMany(PatientPreeclamsiaScreenings::class, 'code_history', 'history_skrining_preklampsia_code');
    }

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }

    public function scheduleAncs()
    {
        return $this->belongsTo(ScheduleANC::class);
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
