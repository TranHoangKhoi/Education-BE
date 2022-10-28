<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_id','created_at','update_at'
    ];
    protected $table = 'course';

    public function class() {
        return $this->hasMany(ClassModel::class, 'id');
   }
}
