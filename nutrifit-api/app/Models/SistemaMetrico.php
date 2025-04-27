<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SistemaMetrico extends Model
{
    //
    use HasFactory;
    protected $table = 'sistema_metrico';
    protected $fillable = [
        'SistemaMetrico_ID',
        'nombre',
        'fecha_creacion',
        'estado',
    ];
    protected $hidden = ['created_at', 'updated_at'];
    // Indicar que 'SistemaMetrico_ID' es la clave primaria
    protected $primaryKey = 'SistemaMetrico_ID';
    // Si quieres que Laravel lo trate como un entero
}
