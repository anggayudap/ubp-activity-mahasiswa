<?php

namespace App\Models;

use App\Models\KompetisiSkema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Skema extends Model
{
    use HasFactory;

    protected $table = 'skemas';

    protected $guarded = ['id'];

    protected $fillable = ['nama_skema', 'deskripsi_skema', 'aktif', 'created_at', 'updated_at'];

    public function kompetisi_skema()
    {
        return $this->hasMany(KompetisiSkema::class, 'skema_id');
    }
}
