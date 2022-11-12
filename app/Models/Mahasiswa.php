<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswas';

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'nim',
        'nama_mahasiswa',
        'prodi',
        'periode_masuk',
        'created_at',
        'updated_at',
    ];
}
