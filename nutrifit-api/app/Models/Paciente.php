<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; //

class Paciente extends Model
{
    //

    use HasFactory; //

    protected $table = 'paciente';
    protected $fillable = [
        'foto',
        'nombre',
        'apellidos',
        'email',
        'telefono',
        'genero',
        'usuario',
        'rol_id',
        'user_id', // <- Nuevo campo para relacionar con users.id
        'enfermedad',
        'status',
        'estado',
        'fecha_nacimiento',
        'edad',
        'localidad', //<-Es Estado(localidad)
        'ciudad',
        'fecha_creacion',
    ];
    // Indicar que 'Talla_ID' es la clave primaria
    protected $primaryKey = 'Paciente_ID';

    // Relación con el rol
    public function role()
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    // Relación con el usuario (nutriólogo)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
