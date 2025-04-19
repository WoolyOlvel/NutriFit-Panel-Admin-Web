<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Rol;
use Illuminate\Database\Eloquent\Factories\HasFactory; //

class User extends Authenticatable
{
    use HasFactory; //

    protected $table = 'users';

    protected $fillable = [
        'nombre',
        'apellidos',
        'email',
        'usuario',
        'password',
        'rol_id',
        'activo',
        'eliminado',
        'remember_token',
    ];

    protected $hidden = ['password'];

    public function role()
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }
}
