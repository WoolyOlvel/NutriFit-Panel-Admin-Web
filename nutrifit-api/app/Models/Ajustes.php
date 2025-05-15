<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ajustes extends Model
{
    use HasFactory;
    protected $table = 'ajustes';
    protected $fillable = [
        "Ajuste_ID",
        "user_id",
        "rol_id",

        "foto",
        "foto_portada",
        "nombre_nutriologo",
        "apellido_nutriologo",
        "telefono",
        "email",
        "edad",
        "pacientes_tratados",
        "especialidad",
        "profesion",
        "horario_antencion",
        "descripcion_nutriologo",
        "ciudad",
        "estado",
        "genero",
        "fecha_nacimiento",
        "universidad",
        "displomados",
        "especializacion",
        "descripcion_especialziacion",
        "experiencia",
        "enfermedades_tratadas",
        "disponibilidad",
        "modalidad",

        "fecha_creacion",

    ];
    protected $hidden = ['created_at', 'updated_at'];
    protected $primaryKey = "Ajuste_ID";
    protected $casts = [
        'user_id' => 'integer',
        'rol_id' => 'integer',
        'foto' => 'string',
        'foto_portada' => 'string',
        'telefono' => 'string',
        'email' => 'string',
        'edad' => 'integer',
        'pacientes_tratados' => 'integer',
        'horario_antencion' => 'string',
        'descripcion_nutriologo' => 'string',
        'ciudad' => 'string',
        'estado' => 'string',
        'genero' => 'string',
        'fecha_nacimiento' => 'date',
        'universidad' => 'string',
        'displomados' => 'string',
        'especializacion' => 'string',
        'descripcion_especialziacion' => 'string',
        'experiencia' => 'string',
        "enfermedades_tratadas" => "string",
    ];
        public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
