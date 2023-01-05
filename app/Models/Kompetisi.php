<?php

namespace App\Models;

use App\Models\KompetisiSkema;
use App\Models\KompetisiParticipant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kompetisi extends Model
{
    use HasFactory;

    protected $table = 'kompetisis';

    protected $guarded = ['id'];

    protected $fillable = ['nama_kompetisi', 'list_prodi', 'tanggal_buka_pendaftaran', 'tanggal_tutup_pendaftaran', 'list_penilaian', 'aktif', 'created_at', 'updated_at'];

    public function skema()
    {
        return $this->hasMany(KompetisiSkema::class, 'kompetisi_id');
    }

    public function participant()
    {
        return $this->hasMany(KompetisiParticipant::class, 'kompetisi_id');
    }
}
