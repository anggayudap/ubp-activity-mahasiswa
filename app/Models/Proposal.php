<?php

namespace App\Models;

use App\Models\Prodi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proposal extends Model {
    use HasFactory;

    protected $table = 'proposals';

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'date',
        'nim',
        'nama_mahasiswa',
        'prodi',
        'judul_proposal',
        'ketua_pelaksana',
        'tanggal_mulai',
        'tanggal_akhir',
        'anggaran_pengajuan',
        'file_proposal',
        'current_status',
        'next_approval',
        'fakultas_user_id',
        'fakultas_user_name',
        'fakultas_approval_date',
        'rejected_fakultas',
        'kemahasiswaan_user_id',
        'kemahasiswaan_user_name',
        'kemahasiswaan_approval_date',
        'rejected_kemahasiswaan',
        'file_laporan',
        'laporan_uploaded',
        'laporan_deadline',
        'laporan_kemahasiswaan_user_id',
        'laporan_kemahasiswaan_user_name',
        'laporan_kemahasiswaan_approval_date',
        'laporan_rejected_kemahasiswaan',
        'is_editable',
        'reject_note',
        'created_at',
        'updated_at',
    ];

    public function prodi_mahasiswa() {
        return $this->belongsTo(Prodi::class, 'prodi', 'kode_prodi');
    }
}
