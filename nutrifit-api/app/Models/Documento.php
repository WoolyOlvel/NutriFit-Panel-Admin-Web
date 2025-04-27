<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Documento extends Model
{
    use HasFactory;
    protected $table = 'documento';
    protected $fillable = [
        'Documento_ID',
        'nombre',
        'tipo_documento',
        'fecha_creacion',
        'estado',
    ];
    protected $hidden = ['created_at', 'updated_at'];
    // Indicar que 'Documento_ID' es la clave primaria
    protected $primaryKey = 'Documento_ID';
}
