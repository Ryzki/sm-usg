<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ScheduleANC extends Model
{
    use HasFactory;

    protected $table = 'schedule_ancs';

    protected $fillable = ['user_id', 'visit_id', 'schedule_date', 'status'];

    protected $dates = ['schedule_date'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function visit()
    {
        return $this->belongsTo(Visit::class, 'visit_id');
    }

    public function getFormattedScheduleDateAttribute()
    {
        return $this->schedule_date->format('d F Y');
    }

    public function getFormatScheduleDateAttribute()
    {
        return $this->schedule_date->format('Y-m-d');
    }
}
