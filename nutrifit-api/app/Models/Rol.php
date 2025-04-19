<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory; //

class Rol extends Model
{
    use HasFactory; //

    protected $table = 'rol';

    protected $fillable = [
        'nombre',
        'estado', // activo o inactivo
        'eliminado'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'rol_id');
    }
}
