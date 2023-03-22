<?php

namespace App\Models;

use App\Models\Skema;
use App\Models\Review;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SkemaReview extends Model {
    use HasFactory;

    protected $table = 'skema_reviews';

    protected $guarded = ['id'];

    protected $fillable = [
        'skema_id', 
        'review_id', 
        'created_at', 
        'updated_at'];

    public function skema() {
        return $this->belongsTo(Skema::class, 'skema_id');
    }

    public function review() {
        return $this->belongsTo(Review::class, 'review_id');
    }
}
