<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_user', 'name', 'name_id', 'phone', 'address', 'role',
    ];

    protected $table = 'admin';
    public $timestamps = false;

    public function user() {
        return $this->hasOne(User::class, 'id', 'id_user');
    }
}
