<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Estatura extends Model
{
    //
    use HasFactory;
    protected $table = 'estatura';
    protected $fillable = [
        'Estatura_ID',
        'nombre',
        'fecha_creacion',
        'estado',
    ];
    protected $hidden = ['created_at', 'updated_at'];
    // Indicar que 'Estatura_ID' es la clave primaria
    protected $primaryKey = 'Estatura_ID';
}
