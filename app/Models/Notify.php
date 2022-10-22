<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notify extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_cate','title','content','created_at','update_at'
    ];
    protected $table = 'notify';
}
