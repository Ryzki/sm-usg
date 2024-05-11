<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = ['sub_district_id', 'residential_association', 'status'];

    public function subDistrict()
    {
        return $this->belongsTo(SubDistrict::class);
    }

    public function midwifeAreas()
    {
        return $this->hasMany(MidwifeArea::class);
    }
}
