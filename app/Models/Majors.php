<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Majors extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_field','name_id','name_major','created_at','update_at'
    ];
    protected $table = 'majors';

    public function field() {
        return $this->hasOne(Field::class, 'id', 'id_field');
   }
   public function class() {
    return $this->hasMany(ClassModel::class, 'id');
}
}
