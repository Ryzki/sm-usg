<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleANC extends Model
{
    use HasFactory;

    protected $table = 'schedule_ancs';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function visit()
    {
        return $this->belongsTo(Visit::class, 'visit_id');
    }
}
