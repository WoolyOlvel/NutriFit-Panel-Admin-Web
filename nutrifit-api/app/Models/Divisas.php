<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Divisas extends Model
{
    //
    use HasFactory;
    protected $table = 'divisas';
    protected $fillable = [
        'Divisa_ID',
        'nombre',
        'fecha_creacion',
        'tasa_cambio',
        'estado',
    ];
    protected $hidden = ['created_at', 'updated_at'];
    // Indicar que 'Divisa_ID' es la clave primaria
    protected $primaryKey = 'Divisa_ID';

}
