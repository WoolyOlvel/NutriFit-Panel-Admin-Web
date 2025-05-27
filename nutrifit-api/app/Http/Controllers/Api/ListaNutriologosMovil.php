<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ajustes;
class ListaNutriologosMovil extends Controller
{
   public function getNutriologos()
    {
        // Obtener directamente de la tabla Ajustes los registros con los campos necesarios
        // Omitiendo el filtro por status si no existe en tu modelo
        $nutriologos = Ajustes::where('rol_id', 1) // Asumiendo que rol_id 1 es para nutriólogos
            ->select(
                'Ajuste_ID',
                'user_id',
                'nombre_nutriologo',
                'apellido_nutriologo',
                'foto',
                'especialidad',
                'modalidad',
                'disponibilidad'
            )
            ->get();

        return response()->json([
            'success' => true,
            'data' => $nutriologos
        ]);
    }

    public function getNutriologoById(Request $request){

         $request->validate([
            'user_id' => 'required|integer'
        ]);

        $user_id = $request->user_id;

        $nutriologo = Ajustes :: where ('rol_id', 1)
            ->where('user_id', $user_id)
            ->select(
                'Ajuste_ID',
                'user_id',
                'nombre_nutriologo',
                'apellido_nutriologo',
                'foto',
                'especializacion',
                'edad',
                'fecha_nacimiento',
                'ciudad',
                'estado',
                'genero',
                'pacientes_tratados',
                'experiencia',
                'horario_antencion',
                'descripcion_nutriologo',
                'enfermedades_tratadas'
            )
            ->first();
        if (!$nutriologo) {
            return response()->json([
                'success' => false,
                'message' => 'Nutriólogo no encontrado'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $nutriologo
        ]);
    }

    public function getNutriologoDetallesById(Request $request){

         $request->validate([
            'user_id' => 'required|integer'
        ]);

        $user_id = $request->user_id;

        $nutriologo = Ajustes :: where ('rol_id', 1)
            ->where('user_id', $user_id)
            ->select(
                'Ajuste_ID',
                'user_id',
                'nombre_nutriologo',
                'apellido_nutriologo',
                'foto',
                'especializacion',
                'edad',
                'fecha_nacimiento',
                'ciudad',
                'estado',
                'genero',
                'pacientes_tratados',
                'experiencia',
                'horario_antencion',
                'descripcion_nutriologo',
                'enfermedades_tratadas',
                'profesion',
                'universidad',
                'telefono',
                'displomados',
                'especialidad',
                'descripcion_especialziacion'

            )
            ->first();
        if (!$nutriologo) {
            return response()->json([
                'success' => false,
                'message' => 'Nutriólogo no encontrado'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $nutriologo
        ]);
    }

}
