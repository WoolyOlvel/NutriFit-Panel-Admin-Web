<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ListaNutriologosMovil extends Controller
{
    public function getNutriologos()
{
    // Obtener todos los usuarios con rol de nutriólogo (asumiendo que rol_id 1 es nutriólogo)
    $nutriologos = User::where('rol_id', 1)
        ->with('ajustes') // Asumiendo que hay una relación ajustes en el modelo User
        ->get();

    $nutriologosData = $nutriologos->map(function ($nutriologo) {
        return [
            'user_id' => $nutriologo->id,
            'nombre_nutriologo' => $nutriologo->nombre,
            'apellido_nutriologo' => $nutriologo->apellidos,
            'foto' => $nutriologo->ajustes->foto_perfil ?? null,
            'modalidad' => $nutriologo->ajustes->modalidad ?? null,
            'disponibilidad' => $nutriologo->ajustes->disponibilidad ?? null,
            'especialidad' => $nutriologo->ajustes->especialidad ?? null
        ];
    });

    return response()->json([
        'success' => true,
        'data' => $nutriologosData
    ]);
}
}
