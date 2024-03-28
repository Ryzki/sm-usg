<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MidwifeArea extends Model
{
    use HasFactory;

    protected $table = 'midwife_areas';

    public function User()
    {
        return $this->belongsTo(User::class, 'midwife_id')->where('role_id', 2);
    }

    public function Areas()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }
}
