<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KlasifikasiKegiatan extends Model {
    use HasFactory;

    protected $table = 'klasifikasi_kegiatans';

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'name_kegiatan',
        'group_kegiatan',
        'alternate_name_kegiatan',
        'created_at',
        'updated_at',
    ];
}
