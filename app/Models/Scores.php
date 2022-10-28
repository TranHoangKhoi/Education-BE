<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scores extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_subject', 'id_student'
    ];

    public function subject() {
        return $this-> hasOne(Subject::class, 'id', 'id_subject');
    }

    public function detailsScore() {
        return $this->hasMany(DetailScores::class, 'id_score');
    }
    public function students() {
        return $this->hasMany(Students::class, 'id_student');
    }

}
