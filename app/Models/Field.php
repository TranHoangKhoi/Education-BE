<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;
    protected $fillable = [
        'field_type','created_at','update_at'
    ];
    protected $table = 'field';

    public function majors() {
        return $this->hasMany(Majors::class, 'id');
    }
}
