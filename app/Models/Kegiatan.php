<?php

namespace App\Models;

use App\Models\Periode;
use App\Models\KlasifikasiKegiatan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kegiatan extends Model {
    use HasFactory;

    protected $table = 'kegiatans';

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'nim',
        'nama_mahasiswa',
        'prodi',
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
        'status',
        'decision_warek',
        'created_at',
        'updated_at',
    ];

    public function periode() {
        return $this->belongsTo(Periode::class, 'periode_id');
    }
    
    public function klasifikasi() {
        return $this->belongsTo(KlasifikasiKegiatan::class, 'klasifikasi_id');
    }
}
