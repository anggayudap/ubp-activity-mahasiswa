<?php

namespace App\Models;

use App\Models\Kegiatan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function kegiatan() {
        return $this->hasMany(Kegiatan::class);
    }
}
