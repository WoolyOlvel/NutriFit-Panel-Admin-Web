<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Talla extends Model
{
    //
    use HasFactory;
    protected $table = 'talla';
    protected $fillable = [
        'Talla_ID',
        'nombre',
        'fecha_creacion',
        'estado',
    ];
    protected $hidden = ['created_at', 'updated_at'];

    // Indicar que 'Talla_ID' es la clave primaria
    protected $primaryKey = 'Talla_ID';

    // Si quieres que Laravel lo trat
}
