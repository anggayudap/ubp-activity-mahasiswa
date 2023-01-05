<?php

namespace App\Models;

use App\Models\Review;
use App\Models\KompetisiParticipant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KompetisiParticipantReview extends Model
{
    use HasFactory;

    protected $table = 'kompetisi_participant_reviews';

    protected $guarded = ['id'];

    protected $fillable = ['participant_id', 'review_id', 'teks_review', 'skor_review', 'created_at', 'updated_at'];

    public function participant()
    {
        return $this->belongsTo(KompetisiParticipant::class, 'participant_id');
    }

    public function review()
    {
        return $this->belongsTo(Review::class, 'review_id');
    }
}
