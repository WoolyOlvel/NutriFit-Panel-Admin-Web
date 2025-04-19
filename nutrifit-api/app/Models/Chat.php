<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $table = 'chat';
    protected $fillable = [
        'id',
        'name',
        'message',
        'image',
        'time',
        'read',
        'isOnline',
        'isCurrentUser',
        'created_at',
    ];
    protected $casts = [
        'time' => 'datetime',
        'created_at' => 'datetime',
    ];
}
