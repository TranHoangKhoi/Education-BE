<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectType extends Model
{
    use HasFactory;
    protected $fillable = [
        'type','created_at','update_at'
    ];
    protected $table = 'subject_type';
}
