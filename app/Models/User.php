<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = ['id'];

    protected $hidden = [
        'nik',
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function midwife()
    {
        return $this->belongsTo(User::class, 'midwife_id')->select('id', 'full_name', 'email', 'phone_number');
    }

    public function scheduleAncs()
    {
        return $this->hasMany(ScheduleANC::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
