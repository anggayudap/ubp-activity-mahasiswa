<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\KompetisiParticipantReview;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';

    protected $guarded = ['id'];

    protected $fillable = ['teks_review', 'deskripsi_review', 'aktif', 'created_at', 'updated_at'];

    public function kompetisi_participant_review()
    {
        return $this->hasMany(KompetisiParticipantReview::class, 'review_id');
    }
}
