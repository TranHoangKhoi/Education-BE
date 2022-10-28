<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $table = 'subject';
    protected $fillable = [
        'id_semester', 'id_class', 'id_major', 'type', 'name_id_subject', 'name', 'credit'
    ];

    public function subjectType() {
        return $this->hasOne(SubjectType::class, 'id','type');
    }
    public function semester() {
        return $this->hasOne(Semester::class, 'id','id_semester');
    }
    public function classData() {
        return $this->hasOne(ClassModel::class, 'id','id_class');
    }
    public function majors() {
        return $this->hasOne(Majors::class, 'id','id_major');
    }

}
