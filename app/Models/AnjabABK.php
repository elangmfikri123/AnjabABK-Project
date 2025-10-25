<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnjabABK extends Model
{
    use HasFactory;

    protected $table = 'anjab_abks';
    protected $guarded = ['id'];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatans_id');
    }

    public function daftarSekolah()
    {
        return $this->belongsTo(DaftarSekolah::class, 'daftar_sekolahs_id');
    }

    public function daftarJabatan()
    {
        return $this->belongsTo(DaftarJabatan::class, 'daftar_jabatans_id');
    }
}
