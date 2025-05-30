<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $table = 'patient';
    protected $fillable = [
        'id',
        'name',
        'age',
        'phone',
        'image',
        'gender',
    ];
    protected $casts = [
        'time' => 'datetime',
    ];
}
