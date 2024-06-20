<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

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

    public function pregnantHistory()
    {
        return $this->hasMany(PregnancyHistory::class, 'pregnant_mother_id', 'id');
    }

    public function historyAncs()
    {
        return $this->hasMany(HistoryANC::class);
    }

    public function midwifeAreas()
    {
        return $this->hasMany(MidwifeArea::class, 'midwife_id');
    }

    public function getAgeAttribute()
    {
        return Carbon::parse($this->date_of_birth)->age;
    }

    public function latestHistoryAncs(): HasOne
    {
        return $this->hasOne(HistoryANC::class)->latestOfMany();
    }

    public function getFullAdressAttribute()
    {
        return $this->home_address . ' RT ' . $this->NA . ' RW ' . $this->NA . ', Kel. ' . $this->subdistrict . ', Kec. ' . $this->district . ', ' . $this->city;
    }

    public function getFormattedPhoneAttribute()
    {
        $nomor_telepon = $this->phone_number;

        if (substr($nomor_telepon, 0, 2) === "62") {
            $nomor_telepon_baru = "0" . substr($nomor_telepon, 2);

            return $nomor_telepon_baru;
        }

        return $nomor_telepon;
    }

    function getDetermineRoleFromFullNameAttribute()
    {
        $nameParts = explode(" ", $this->full_name);
        $firstName = $nameParts[0];

        if (strtolower($firstName) == "dr.") {
            return "Dokter Umum";
        } elseif (strtolower($firstName) == "drg.") {
            return "Dokter Gigi";
        } elseif (strpos($this->full_name, "S.GZ") != false) {
            return "Petugas Gizi";
        } else {
            return null;
        }
    }
}
