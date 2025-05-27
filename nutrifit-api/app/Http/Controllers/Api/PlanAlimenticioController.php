<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Consulta;
use App\Models\Paciente;
use Illuminate\Support\Facades\Log;

class PlanAlimenticioController extends Controller
{
    public function getPlanesAlimenticios(Request $request)
    {
        try {
            // Validar los parámetros de entrada
            $request->validate([
                'pacienteIds' => 'required|array',
                'pacienteIds.*' => 'integer',
                'nutriologoIds' => 'required|array',
                'nutriologoIds.*' => 'integer'
            ]);

            $pacienteIds = $request->input('pacienteIds');
            $nutriologoIds = $request->input('nutriologoIds');

            // Debug: Log para ver qué datos llegan
            Log::info('Datos recibidos:', [
                'pacienteIds' => $pacienteIds,
                'nutriologoIds' => $nutriologoIds
            ]);

            // Obtener consultas que coincidan con pacientes y nutriólogos específicos
            $consultas = Consulta::whereIn('Paciente_ID', $pacienteIds)
                ->whereIn('user_id', $nutriologoIds)
                ->whereNotNull('plan_nutricional_path')
                ->get();

            // Debug: Log consultas encontradas
            Log::info('Consultas encontradas:', ['count' => $consultas->count()]);

            // Procesar cada consulta para agregar los datos adicionales
            $planesCompletos = [];
            foreach ($consultas as $consulta) {
                // Obtener la foto del paciente directamente desde la tabla pacientes
                $fotoPaciente = Paciente::where('Paciente_ID', $consulta->Paciente_ID)
                    ->value('foto');

                // Obtener otros datos del paciente
                $paciente = Paciente::find($consulta->Paciente_ID);

                $planesCompletos[] = [
                    'Consulta_ID' => $consulta->Consulta_ID,
                    'Paciente_ID' => $consulta->Paciente_ID,
                    'user_id' => $consulta->user_id, // ID del nutriólogo
                    'foto_paciente' => $fotoPaciente,
                    'nombre_paciente' => $consulta->nombre_paciente ?? ($paciente ? $paciente->nombre : null),
                    'apellidos' => $consulta->apellidos ?? ($paciente ? $paciente->apellidos : null),
                    'enfermedad' => $paciente ? $paciente->enfermedad : null,
                    'nombre_nutriologo'=>$consulta->nombre_nutriologo ,
                    'plan_nutricional_path' => $consulta->plan_nutricional_path,
                    'fecha_consulta' => $consulta->created_at ? $consulta->created_at->format('Y-m-d') : null
                ];
            }

            return response()->json([
                'success' => true,
                'total' => count($planesCompletos),
                'data' => $planesCompletos
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            // Log del error para debugging
            Log::error('Error en getPlanesAlimenticios:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Método alternativo usando relaciones Eloquent (más eficiente)
    public function getPlanesAlimenticiosConRelaciones(Request $request)
    {
        try {
            $request->validate([
                'pacienteIds' => 'required|array',
                'pacienteIds.*' => 'integer',
                'nutriologoIds' => 'required|array',
                'nutriologoIds.*' => 'integer'
            ]);

            $pacienteIds = $request->input('pacienteIds');
            $nutriologoIds = $request->input('nutriologoIds');

            // Usar eager loading para optimizar las consultas
            $consultas = Consulta::with('paciente:Paciente_ID,nombre,apellidos,enfermedad,foto')
                ->whereIn('Paciente_ID', $pacienteIds)
                ->whereIn('user_id', $nutriologoIds)
                ->whereNotNull('plan_nutricional_path')
                ->get();

            $planesCompletos = $consultas->map(function($consulta) {
                return [
                    'Consulta_ID' => $consulta->Consulta_ID,
                    'Paciente_ID' => $consulta->Paciente_ID,
                    'user_id' => $consulta->user_id,
                    'foto_paciente' => $consulta->paciente?->foto,
                    'nombre_paciente' => $consulta->nombre_paciente ?? $consulta->paciente?->nombre,
                    'apellidos' => $consulta->apellidos ?? $consulta->paciente?->apellidos,
                    'enfermedad' => $consulta->paciente?->enfermedad,
                    'plan_nutricional_path' => $consulta->plan_nutricional_path,
                    'fecha_consulta' => $consulta->created_at ? $consulta->created_at->format('Y-m-d H:i:s') : null
                ];
            });

            return response()->json([
                'success' => true,
                'total' => $planesCompletos->count(),
                'data' => $planesCompletos
            ]);

        } catch (\Exception $e) {
            Log::error('Error en getPlanesAlimenticiosConRelaciones:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

// RUTAS (routes/api.php):
// Route::post('consulta/planes-alimenticios', [PlanAlimenticioController::class, 'getPlanesAlimenticios']);
// Route::post('consulta/planes-alimenticios-relaciones', [PlanAlimenticioController::class, 'getPlanesAlimenticiosConRelaciones']);
