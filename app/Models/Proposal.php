<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model {
    use HasFactory;

    protected $table = 'proposals';

    protected $guarded = [
        'id',
    ];

    protected $fillable = [

        'created_at',
        'updated_at',
    ];
}
