<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;
    // public $timestamps = false;
    protected $fillable = [
        'name_id','id_course','created_at','update_at'
    ];
    protected $table = 'semester';
}
