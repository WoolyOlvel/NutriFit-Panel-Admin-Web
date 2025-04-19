<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $table = 'appointment';
    protected $fillable = [
        'id',
        'name',
        'type',
        'time',
        'image',
        'status',
        'status_type',
    ];
    protected $casts = [
        'date' => 'datetime',
        'time' => 'datetime',
    ];
}
