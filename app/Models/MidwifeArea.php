<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MidwifeArea extends Model
{
    use HasFactory;

    protected $table = 'midwife_areas';

    protected $fillable = ['midwife_id', 'area_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'midwife_id');
    }

    public function areas()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }
}
