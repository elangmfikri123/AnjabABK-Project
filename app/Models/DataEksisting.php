<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataEksisting extends Model
{
    use HasFactory;

    protected $table = 'data_eksistings';
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

    public function jenisGuru()
    {
        return $this->belongsTo(JenisGuru::class, 'jenis_gurus_id');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapels_id');
    }
}
