<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'nama',
        'username',
        'password',
        'email',
        'role',
        'login_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getDisplayNameAttribute()
    {
        switch ($this->role) {
            case 'Admin':
                return $this->nama;
            case 'Operator':
                return $this->nama;
            default:
                return $this->nama;
        }
    }
    public function getInitialsAttribute()
    {
        $name = $this->display_name;
        $words = explode(' ', trim($name));
        $initials = '';

        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper(mb_substr($word, 0, 1));
            }
            if (strlen($initials) >= 2) break;
        }

        return substr($initials, 0, 2); // pastikan maksimal 2 huruf
    }
    public function sessions()
    {
        return $this->hasMany(\Illuminate\Session\DatabaseSessionHandler::class, 'user_id');
    }
    public function sekolah()
    {
        return $this->belongsTo(\App\Models\DaftarSekolah::class, 'daftar_sekolahs_id');
    }
}
