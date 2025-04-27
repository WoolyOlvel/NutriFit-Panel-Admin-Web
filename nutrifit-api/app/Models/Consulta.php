<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;
    protected $table = 'consulta';
    protected $fillable = [
        'Consulta_ID',
        'Paciente_ID',
        'user_id',          // ID del nutriólogo
        'Documento_ID',     // Relacionado con los documentos
        'Pago_ID',          // Tipo de pago
        'Divisa_ID',        // Tipo de divisa

        //Datos del paciente
        'nombre_paciente', //relacionado al Paciente_ID, De acuerdo al ID se obtiene el nombre
        'apellidos',
        'email',
        'telefono',
        'genero',
        'usuario',
        'enfermedad',
        'localidad',
        'ciudad',
        'edad',
        'fecha_nacimiento',
        'nombre_nutriologo', //De acuerdo al user_id se obtiene el nombre del nutriologo

        //Datos adicionales de consulta
        'peso',
        'talla',
        'cintura',
        'cadera',
        'gc',
        'em',
        'altura',
        // Campos de diagnóstico y evaluación
        'detalles_diagnostico',
        'resultados_evaluacion',
        'analisis_nutricional',
        'objetivo_descripcion',

        'proxima_consulta',
        'plan_nutricional_path', // Ruta al archivo del plan nutricional
        'total_pago',
        'fecha_creacion',
        'estado',
    ];

    protected $hidden = ['created_at', 'updated_at'];
    // Indicar que 'Consulta_ID' es la clave primaria
    protected $primaryKey = 'Consulta_ID';

    // Relación con el modelo Paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'Paciente_ID');
    }

    // Relación con el modelo User (nutriólogo)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación con el modelo Rol
    public function role()
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    // Relación con el modelo Documento
    public function documento()
    {
        return $this->belongsTo(Documento::class, 'Documento_ID');
    }

    // Relación con el modelo Pago
    public function pago()
    {
        return $this->belongsTo(Pago::class, 'Pago_ID');
    }

    // Relación con el modelo Divisa
    public function divisa()
    {
        return $this->belongsTo(Divisas::class, 'Divisa_ID');
    }


}
