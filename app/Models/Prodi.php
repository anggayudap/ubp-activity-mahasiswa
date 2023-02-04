<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\KompetisiParticipantMember;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prodi extends Model {
    use HasFactory;

    protected $table = 'prodis';

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'kode_prodi',
        'nama_prodi',
        'created_at',
        'updated_at',
    ];

    public function mahasiswa_participant() {
        return $this->hasMany(KompetisiParticipantMember::class, 'kode_prodi', 'prodi');
    }
}
