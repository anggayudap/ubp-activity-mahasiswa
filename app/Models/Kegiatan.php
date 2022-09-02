<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model {
    use HasFactory;

    protected $table = 'kegiatans';

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'nim',
        'nama_mahasiswa',
        'periode_id',
        'tahun_periode',
        'nama_kegiatan',
        'tanggal_mulai',
        'tanggal_akhir',
        'klasifikasi_id',
        'surat_tugas',
        'foto_kegiatan',
        'url_event',
        'bukti_sertifikat',
        'keterangan',
        'checked_kemahasiswaan',
        'checked_warek',
        'decision_warek',
        'created_at',
        'updated_at',
    ];
}
