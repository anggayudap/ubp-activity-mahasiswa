<?php

namespace App\Models;

use App\Models\Kompetisi;
use Illuminate\Database\Eloquent\Model;
use App\Models\KompetisiParticipantMember;
use App\Models\KompetisiParticipantReview;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KompetisiParticipant extends Model
{
    use HasFactory;

    protected $table = 'reviews';

    protected $guarded = ['id'];

    protected $fillable = ['kompetisi_id', 'nip_dosen', 'nama_dosen', 'email_dosen', 'prodi_dosen', 'judul', 'tahun', 'nama_skema', 'deskripsi_skema', 'file_upload', 'review', 'catatan', 'tanggal_approval', 'user_approval', 'nama_approval', 'keputusan', 'created_at', 'updated_at'];

    public function kompetisi()
    {
        return $this->belongsTo(Kompetisi::class, 'kompetisi_id');
    }

    public function member()
    {
        return $this->hasMany(KompetisiParticipantMember::class, 'participant_id');
    }

    public function review()
    {
        return $this->hasMany(KompetisiParticipantReview::class, 'paricipant_id');
    }
}
