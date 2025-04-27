<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ComposicionCorporal extends Model
{
    //

    use HasFactory;
    protected $table = 'composicion_corporal';
    protected $fillable = [
        'ComposicionCorporal_ID',
        'nombre',
        'fecha_creacion',
        'estado',
    ];
    protected $hidden = ['created_at', 'updated_at'];
    // Indicar que 'ComposicionCorporal_ID' es la clave primaria
    protected $primaryKey = 'ComposicionCorporal_ID';
}
