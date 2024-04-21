<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PregnancyHistory extends Model
{
    use HasFactory;

    protected $fillable = ['pregnant_mother_id', 'last_period_date', 'estimated_due_date', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'pregnant_mother_id', 'id');
    }

    public function getGestationalAgeInWeeksAttribute()
    {
        $estimatedDueDate = $this->estimated_due_date;
        $today = Carbon::now();

        $diffInDays = $today->diffInDays($estimatedDueDate);
        $weeks = floor($diffInDays / 7);

        return $weeks;
    }
}
