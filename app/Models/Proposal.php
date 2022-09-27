<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'fakultas_approval_date',
        'rejected_fakultas',
        'kemahasiswaan_approval_date',
        'rejected_kemahasiswaan',
        'rektor_approval_date',
        'is_editable',
        'reject_note',
        'created_at',
        'updated_at',
    ];
}
