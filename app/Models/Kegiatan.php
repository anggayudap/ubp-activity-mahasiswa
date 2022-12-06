<?php

namespace App\Models;

use App\Models\Prodi;
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
        'url_publikasi',
        'bukti_kegiatan',
        'keterangan',
        'status',
        'prestasi',
        'cakupan',
        'approval',
        'kemahasiswaan_user_id',
        'kemahasiswaan_user_name',
        'created_at',
        'updated_at',
    ];

    public function periode() {
        return $this->belongsTo(Periode::class, 'periode_id');
    }
    
    public function klasifikasi() {
        return $this->belongsTo(KlasifikasiKegiatan::class, 'klasifikasi_id');
    }

    public function prodi_mahasiswa() {
        return $this->belongsTo(Prodi::class, 'prodi', 'kode_prodi');
    }
}
