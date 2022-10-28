<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationCate extends Model
{
    use HasFactory;
    protected $table = 'notification_categories';
    protected $fillable = [
        'name_cate','created_at','update_at'
    ];

    // public function notify() {
    //     return $this->hasMany(Notify::class, 'id');
    // }
}
