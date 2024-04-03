<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodSupplement extends Model
{
    use HasFactory;

    protected $fillable = ['pregnant_mother_id', 'start_end', 'status'];
}
