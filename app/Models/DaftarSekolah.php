<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarSekolah extends Model
{
    use HasFactory;

    protected $table = 'daftar_sekolahs';
    protected $guarded = ['id'];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatans_id');
    }

    public function anjabAbks()
    {
        return $this->hasMany(AnjabABK::class, 'daftar_sekolahs_id');
    }

    public function dataEksistings()
    {
        return $this->hasMany(DataEksisting::class, 'daftar_sekolahs_id');
    }
}
