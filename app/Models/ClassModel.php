<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;
    protected $table = 'class';
    
    protected $fillable = [
       'id_course','id_major', 'name_id','created_at','update_at'
    ];


    public function student() {
        return $this->hasMany(Students::class, 'id');
    }
}
