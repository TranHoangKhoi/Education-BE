<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;
    protected $table = 'class';

    protected $fillable = [
       'id_course','id_major', 'name_class','created_at','update_at'
    ];

    public function student() {
        return $this->hasMany(Students::class, 'id');
    }
    //1 khoa co nhieu classs
    public function course() {
        return $this->hasOne(Course::class, 'id', 'id_course');
   }

   public function majors() {
    return $this->hasOne(Majors::class, 'id', 'id_major');
    }
    public function subject() {
        return $this->hasMany(Subject::class, 'id');
    }

}
