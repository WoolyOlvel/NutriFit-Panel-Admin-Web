<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_Consulta extends Model
{
    use HasFactory;
    protected $table = 'tipo_consulta';
    protected $fillable = [
        'Tipo_Consulta_ID',
        'Nombre',
        'Precio',
        'Duracion',
        'total_pago',
        'Estado',
        "fecha_creacion",
    ];
    protected $hidden = ['created_at', 'updated_at'];
    // Indicar que 'Tipo_Consulta_ID' es la clave primaria
    protected $primaryKey = 'Tipo_Consulta_ID';
    // Relación con el modelo Consulta
    public function consulta()
    {
        return $this->hasMany(Consulta::class, 'Tipo_Consulta_ID', 'Tipo_Consulta_ID');
    }
}
