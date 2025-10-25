<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisGuru extends Model
{
    use HasFactory;

    protected $table = 'jenis_gurus';
    protected $guarded = ['id'];

    public function dataEksistings()
    {
        return $this->hasMany(DataEksisting::class, 'jenis_gurus_id');
    }
}
