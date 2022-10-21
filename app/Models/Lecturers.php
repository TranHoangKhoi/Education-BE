<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecturers extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_user', 'name_id', 'name', 'phone', 'address', 'gender'
    ];

    public function user() {
        return $this->hasOne(User::class, 'id', 'id_user');
    }
}
