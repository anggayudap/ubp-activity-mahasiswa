<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosens';

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'nip',
        'jabatan_struktural',
        'id_sipt',
        'nama',
        'email',
        'nidn',
        'singkatan',
        'prodi',
        'created_at',
        'updated_at',
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi', 'kode_prodi');
    }
}
