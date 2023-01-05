<?php

namespace App\Models;

use App\Models\KompetisiParticipant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KompetisiParticipantMember extends Model
{
    use HasFactory;

    protected $table = 'kompetisi_participant_members';

    protected $guarded = ['id'];

    protected $fillable = ['participant_id', 'nim', 'nama_mahasiswa', 'prodi', 'status_keanggotaan', 'created_at', 'updated_at'];

    public function kompetisi_participant_review()
    {
        return $this->belongsTo(KompetisiParticipant::class, 'participant_id');
    }
}
