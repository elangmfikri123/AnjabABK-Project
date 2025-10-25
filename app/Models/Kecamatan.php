<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;

    protected $table = 'kecamatans';
    protected $guarded = ['id'];


    public function daftarSekolahs()
    {
        return $this->hasMany(DaftarSekolah::class, 'kecamatans_id');
    }
    public function anjabAbks()
    {
        return $this->hasMany(AnjabABK::class, 'kecamatans_id');
    }
    public function dataEksistings()
    {
        return $this->hasMany(DataEksisting::class, 'kecamatans_id');
    }
}
