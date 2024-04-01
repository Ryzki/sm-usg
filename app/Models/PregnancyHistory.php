<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PregnancyHistory extends Model
{
    use HasFactory;

    protected $fillable = ['pregnant_mother_id', 'last_period_date', 'estimated_due_date', 'status'];
}
