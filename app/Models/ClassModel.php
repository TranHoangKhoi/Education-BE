<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;
    protected $fillable = [
       'id_course','id_major', 'name_id','created_at','update_at'
    ];
    protected $table = 'class';
}
