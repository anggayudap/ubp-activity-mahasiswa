<?php

namespace App\Models;

use App\Models\Skema;
use App\Models\Kompetisi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KompetisiSkema extends Model
{
    use HasFactory;

    protected $table = 'kompetisi_skemas';

    protected $guarded = ['id'];

    protected $fillable = ['kompetisi_id', 'skema_id', 'nama_skema', 'created_at', 'updated_at'];

    public function kompetisi()
    {
        return $this->belongsTo(Kompetisi::class, 'kompetisi_id');
    }

    public function skema()
    {
        return $this->belongsTo(Skema::class, 'skema_id');
    }
}
