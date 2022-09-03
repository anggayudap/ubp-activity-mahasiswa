<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model {
    use HasFactory;

    protected $table = 'prodis';

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'kode_prodi',
        'nama_prodi',
        'created_at',
        'updated_at',
    ];
}
