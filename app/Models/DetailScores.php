<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailScores extends Model
{
    use HasFactory;
    protected $table = 'detail_scores';

    protected $fillable = [
        'id_score', 'title', 'score', 'note', 'percent'
    ];
}
