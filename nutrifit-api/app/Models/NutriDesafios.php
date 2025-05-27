<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NutriDesafios extends Model
{
    use HasFactory;
    protected $table = 'nutridesafios';
    protected $fillable = [
        'NutriDesafios_ID',
        'foto',
        'nombre',
        'url',
        'tipo',
        'fecha_creacion',
        'status', // 1 = Activo, 2 = Proximamente 3 = Inactivo
        'estado' // 0 =  Inactivo, 1 = Activo
    ];
    protected $hidden = ['created_at', 'updated_at'];

    protected $primaryKey = 'NutriDesafios_ID';
    protected $casts = [
        'foto' => 'string',
        'nombre' => 'string',
        'url' => 'string',
        'tipo' => 'string',
        'estado' => 'integer',

    ];
        // Relación con el usuario (nutriólogo)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Accesor para el estado (opcional)
    public function getEstadoTextoAttribute()
    {
        return match($this->status) {
            0 => 'Inactivo',
            1 => 'Activo',
            2 => 'Proximamente',
            default => 'Desconocido'
        };
    }



}
