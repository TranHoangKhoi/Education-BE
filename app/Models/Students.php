<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    use HasFactory;
    protected $table = 'students';

    protected $fillable = [
        'id_user', 'id_course', 'id_class', 'id_major', 'mssv', 'name', 'phone', 'gender','email'
    ];

    public function user() {
        return $this->hasOne(User::class, 'id', 'id_user');
    }

    public function class() {
        // $d = $this->hasOne(ClassModel::class, 'id');
        // dd($d);
        return $this->hasOne(ClassModel::class, 'id', 'id_class');
    }

    public function majors() {
        return $this->hasOne(Majors::class, 'id', 'id_major');
    }

    public function course() {
        return $this->hasOne(Course::class, 'id', 'id_course');
    }
}
