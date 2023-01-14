<?php

namespace App\Models;

use App\Models\Kompetisi;
use App\Models\KompetisiParticipantMember;
use App\Models\KompetisiParticipantReview;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KompetisiParticipant extends Model {
    use HasFactory;

    protected $table = 'kompetisi_participants';

    protected $guarded = ['id'];

    protected $fillable = [
        'kompetisi_id',
        'id_dosen_pembimbing',
        'nip_dosen_pembimbing',
        'nama_dosen_pembimbing',
        'email_dosen_pembimbing',
        'prodi_dosen_pembimbing',
        'judul',
        'tahun',
        'nama_skema',
        'deskripsi_skema',
        'file_upload',
        'id_dosen_penilai',
        'nip_dosen_penilai',
        'nama_dosen_penilai',
        'email_dosen_penilai',
        'prodi_dosen_penilai',
        'catatan',
        'tanggal_approval',
        'user_approval',
        'nama_approval',
        'keputusan',
        'is_editable',
        'user_created',
        'user_updated',
        'created_at',
        'updated_at',
    ];

    public function kompetisi() {
        return $this->belongsTo(Kompetisi::class, 'kompetisi_id');
    }

    public function member() {
        return $this->hasMany(KompetisiParticipantMember::class, 'participant_id');
    }

    public function review() {
        return $this->hasMany(KompetisiParticipantReview::class, 'participant_id');
    }
}
