<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservaciones;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;

class SeguimientoController extends Controller
{
    public function verificarSeguimiento($reservacionId, $pacienteId)
    {
        try {
            // Buscar la reservación original
            $original = Reservaciones::findOrFail($reservacionId);

            // Verificar que pertenece al paciente
            if ($original->Paciente_ID != $pacienteId) {
                return response()->json([
                    'success' => false,
                    'message' => 'No autorizado'
                ], 403);
            }

            // Buscar reservaciones de seguimiento para esta cita
            $seguimientos = Reservaciones::where('Paciente_ID', $pacienteId)
                ->where('user_id', $original->user_id)
                ->where('motivo_consulta', 'like', 'Seguimiento%')
                ->where('fecha_consulta', $original->fecha_proximaConsulta)
                ->get();

            return response()->json([
                'success' => true,
                'tiene_seguimiento' => $seguimientos->isNotEmpty(),
                'data' => $seguimientos
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al verificar seguimiento: ' . $e->getMessage()
            ], 500);
        }
    }

    public function verificarSeguimiento2(Request $request)
    {
        try {
            // Validar que se envíen los arrays requeridos
            $request->validate([
                'reservacion_ids' => 'required|array|min:1',
                'reservacion_ids.*' => 'integer',
                'paciente_ids' => 'required|array|min:1',
                'paciente_ids.*' => 'integer'
            ]);

            $reservacionIds = $request->input('reservacion_ids');
            $pacienteIds = $request->input('paciente_ids');

            $resultados = [];

            // Procesar cada reservación
            foreach ($reservacionIds as $reservacionId) {
                // Buscar la reservación original (usando la clave primaria correcta)
                $original = Reservaciones::where('Reservacion_ID', $reservacionId)->first();

                if (!$original) {
                    $resultados[] = [
                        'reservacion_id' => $reservacionId,
                        'success' => false,
                        'message' => 'Reservación no encontrada'
                    ];
                    continue;
                }

                // Verificar si el paciente de la reservación está en la lista de pacientes autorizados
                if (!in_array($original->Paciente_ID, $pacienteIds)) {
                    $resultados[] = [
                        'reservacion_id' => $reservacionId,
                        'paciente_id' => $original->Paciente_ID,
                        'success' => false,
                        'message' => 'No autorizado'
                    ];
                    continue;
                }

                // Buscar reservaciones de seguimiento para esta cita
                $seguimientos = Reservaciones::where('Paciente_ID', $original->Paciente_ID)
                    ->where('user_id', $original->user_id)
                    ->where('motivo_consulta', 'like', 'Seguimiento%')
                    ->where('fecha_consulta', $original->fecha_proximaConsulta)
                    ->get();

                $resultados[] = [
                    'reservacion_id' => $reservacionId,
                    'paciente_id' => $original->Paciente_ID,
                    'success' => true,
                    'tiene_seguimiento' => $seguimientos->isNotEmpty(),
                    'data' => $seguimientos
                ];
            }

            return response()->json([
                'success' => true,
                'resultados' => $resultados
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Datos de entrada inválidos',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al verificar seguimiento: ' . $e->getMessage()
            ], 500);
        }
    }



}
