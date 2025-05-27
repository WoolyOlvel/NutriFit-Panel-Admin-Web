<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservaciones;
use Illuminate\Http\Request;


class ReservacionController extends Controller
{

    public function create(Request $request)
    {
        $request->validate([
            'Paciente_ID' => 'required|integer',
            'nombre_paciente' => 'required|string',
            'precio_cita' => 'required|numeric',
            'motivo_consulta' => 'required|string',
            'nombre_nutriologo' => 'required|string',
            'fecha_consulta' => 'required|date',
            'origen' => 'required|string',
            'estado_proximaConsulta' => 'required|integer',
            'user_id' => 'required|integer' // Añade esta validación
        ]);

        try {
            $reservacion = Reservaciones::create([
                'Paciente_ID' => $request->input('Paciente_ID'),
                'user_id' => $request->input('user_id'), // Añade esta línea
                'nombre_paciente' => $request->input('nombre_paciente'),
                'apellidos' => $request->input('apellidos', ''),
                'telefono' => $request->input('telefono', ''),
                'genero' => $request->input('genero', ''),
                'usuario' => $request->input('usuario', ''),
                'edad' => $request->input('edad', 0),
                'precio_cita' => $request->input('precio_cita'),
                'motivo_consulta' => $request->input('motivo_consulta'),
                'nombre_nutriologo' => $request->input('nombre_nutriologo'),
                'fecha_consulta' => $request->input('fecha_consulta'),
                'origen' => $request->input('origen'),
                'estado_proximaConsulta' => $request->input('estado_proximaConsulta'),
                'type' => 'reservacion'
            ]);
            // Crear UNA sola notificación manualmente
            $reservacion->crearNotificacion('creación');
            return response()->json([
                'success' => true,
                'data' => $reservacion
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear reservación',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
