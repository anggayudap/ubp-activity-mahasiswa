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
        'rektor_approval_date',
        'is_editable',
        'reject_note',
        'created_at',
        'updated_at',
    ];

    public function prodi_mahasiswa() {
        return $this->belongsTo(Prodi::class, 'prodi', 'kode_prodi');
    }
}
