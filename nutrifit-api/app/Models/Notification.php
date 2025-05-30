<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'notifications';
    protected $fillable = [
        'id',
        'title',
        'message',
        'image',
        'time',
        'user_id',
        'created_at',
    ];
    protected $casts = [
        'time' => 'datetime',
    ];
}
