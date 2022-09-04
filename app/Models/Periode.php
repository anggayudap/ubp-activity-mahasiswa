<?php

namespace App\Models;

use App\Models\Kegiatan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Periode extends Model {
    use HasFactory;

    protected $table = 'periodes';

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'periode_awal',
        'periode_akhir',
        'created_at',
        'updated_at',
    ];

    public function kegiatan() {
        return $this->hasMany(Kegiatan::class);
    }
}
