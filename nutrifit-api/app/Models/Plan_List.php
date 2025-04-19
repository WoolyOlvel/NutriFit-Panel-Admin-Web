<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan_List extends Model
{
    use HasFactory;
    protected $table = 'patient';
    protected $fillable = [
        'id',
        'name',
        'image',
        'phone',
        'tipo',
        'tiempo',
    ];

    protected $casts = [
        'time' => 'datetime',
    ];
}
