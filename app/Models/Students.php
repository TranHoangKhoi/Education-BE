<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    use HasFactory;
    protected $table = 'students';

    protected $fillable = [
        'id_course', 'id_class', 'id_major', 'name_id', 'name', 'email', 'password', 'phone', 'gender'
    ];
}
