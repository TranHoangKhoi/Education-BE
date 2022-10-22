<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseScore extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'case_score';
    protected $fillable = [
        'id_subject', 'title', 'name_field', 'percent'
    ];
}
