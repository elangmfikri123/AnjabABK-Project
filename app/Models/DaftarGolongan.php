<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarGolongan extends Model
{
    use HasFactory;

    protected $table = 'daftar_golongans';
    protected $guarded = ['id'];
}
