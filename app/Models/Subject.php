<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $table = 'subject';
    protected $fillable = [
        'id_semester', 'id_class', 'id_major', 'subject_type', 'name_id', 'name', 'credit'
    ];
}
