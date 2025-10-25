<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarJabatan extends Model
{
    use HasFactory;

    protected $table = 'daftar_jabatans';
    protected $guarded = ['id'];

    public function anjabAbks()
    {
        return $this->hasMany(AnjabABK::class, 'daftar_jabatans_id');
    }

    public function dataEksistings()
    {
        return $this->hasMany(DataEksisting::class, 'daftar_jabatans_id');
    }
}
