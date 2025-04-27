<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MedidasCorporales extends Model
{
    //

    use HasFactory;
    protected $table = 'medidas_corporales';
    protected $fillable = [
        'MedidasCorporales_ID',
        'nombre',
        'fecha_creacion',
        'estado',
    ];
    protected $hidden = ['created_at', 'updated_at'];
    // Indicar que 'MedidasCorporales_ID' es la clave primaria
    protected $primaryKey = 'MedidasCorporales_ID';

}
