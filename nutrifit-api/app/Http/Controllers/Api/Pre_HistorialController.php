<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Paciente;
use App\Models\User;
use App\Models\Consulta;
use Exception;

class Pre_HistorialController extends Controller
{
    // Función para verificar el token y obtener el usuario
    private function getUserFromToken(Request $request)
    {
        $token = $request->header('remember-token');
        if (!$token) {
            return null;
        }

        return User::where('remember_token', $token)
            ->where('remember_token_expires_at', '>', now())
            ->first();
    }

    /**
     * Obtiene las consultas de un paciente específico
     */
    // Modificar la función getConsultasPaciente
    public function getConsultasPaciente(Request $request, $pacienteId)
    {
        try {

            $user = $this->getUserFromToken($request);
            if (!$user) {
                return response()->json(['message' => 'No autorizado'], 401);
            }


            // Verificar si el paciente existe
            $paciente = Paciente::find($pacienteId);
            if (!$paciente) {
                return response()->json(['message' => 'Paciente no encontrado'], 404);
            }

            // Obtener la ruta de la imagen del paciente
            $rutaImagen = 'user-dummy-img.jpg'; // Imagen por defecto

            if ($paciente->foto) {
                // Usar directamente la ruta almacenada en la BD
                $rutaImagen = $paciente->foto;
            }

            // Obtener las consultas del paciente
            $consultas = Consulta::where('Paciente_ID', $pacienteId)->get();

            $datosConsultas = [];
            foreach ($consultas as $consulta) {
                // Calculamos el tiempo de actualización de forma segura
                $tiempoActualizacion = $consulta->updated_at ? $consulta->updated_at->diffForHumans() : 'Reciente';

                // CORRECCIÓN: Obtener directamente el nombre del consultorio desde la tabla consulta
                $nombreConsultorio = $consulta->nombre_consultorio ?? 'N/A';

                // CORRECCIÓN: Obtener el tipo de consulta buscando en la tabla tipo_consulta
                $tipoConsulta = 'N/A';
                if ($consulta->Tipo_Consulta_ID) {
                    // Asumiendo que hay un modelo TipoConsulta con una relación
                    $tipoConsultaObj = \App\Models\Tipo_Consulta::find($consulta->Tipo_Consulta_ID);
                    if ($tipoConsultaObj) {
                        $tipoConsulta = $tipoConsultaObj->Nombre ?? 'N/A';
                    }
                }

                $datosConsultas[] = [
                    'id' => $consulta->Consulta_ID,
                    'nombre_paciente' => $paciente->nombre ?? '',
                    'apellidos_paciente' => $paciente->apellidos ?? '',
                    'foto_paciente' => $rutaImagen,
                    'consultorio' => $nombreConsultorio,
                    'tipo_consulta' => $tipoConsulta,
                    'fecha_consulta' => $consulta->fecha_creacion ?? $consulta->created_at,
                    'tiempo_actualizacion' => $tiempoActualizacion
                ];
            }

            // Devolver respuesta de éxito
            return response()->json([
                'status' => 'success',
                'paciente' => [
                    'id' => $paciente->Paciente_ID,
                    'nombre' => $paciente->nombre ?? '',
                    'apellidos' => $paciente->apellidos ?? '',
                    'foto' => $rutaImagen
                ],
                'consultas' => $datosConsultas
            ]);
        } catch (Exception $e) {
            // Capturar cualquier error y devolverlo en la respuesta
            return response()->json([
                'status' => 'error',
                'message' => 'Error al obtener datos: ' . $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
    }
}
