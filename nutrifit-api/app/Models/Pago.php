<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    //
    use HasFactory;
    protected $table = 'pago';
    protected $fillable = [
        'Pago_ID',
        'nombre',
        'fecha_creacion',
        'estado',
    ];
    protected $hidden = ['created_at', 'updated_at'];
    // Indicar que 'pago_id' es la clave primaria
    protected $primaryKey = 'Pago_ID';
}
