<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ajustes;
use App\Models\Consulta;
use App\Models\Paciente;
use App\Models\Tipo_Consulta;
use App\Models\User;

use App\Models\Reservaciones;

class HistorialNutricionalController extends Controller
{
    /**
     * Obtener todas las consultas por lista de pacientes y nutriólogos
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getConsultasPorPaciente(Request $request)
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

            // Obtener las reservaciones para los pacientes y nutriólogos especificados
            $reservaciones = Reservaciones::whereIn('Paciente_ID', $pacienteIds)
                ->whereIn('user_id', $nutriologoIds)
                ->get();

            // Procesar cada reservación para agregar los datos adicionales
            $consultasCompletas = [];
            foreach ($reservaciones as $reservacion) {
                // Obtener la foto del nutriólogo
                $fotoNutriologo = Ajustes::where('user_id', $reservacion->user_id)
                    ->value('foto');

                // Obtener la foto del paciente tal como está almacenada
                $fotoPaciente = Paciente::where('Paciente_ID', $reservacion->Paciente_ID)
                    ->value('foto');

                // Buscar la consulta que corresponda a esta reservación específica
                // Opción 1: Buscar por fecha si ambas tablas tienen fechas similares
                $consulta = Consulta::where('Paciente_ID', $reservacion->Paciente_ID)
                    ->where('user_id', $reservacion->user_id)
                    ->whereDate('fecha_creacion', $reservacion->fecha_consulta->format('Y-m-d'))
                    ->first();

                // Opción 2: Si no encuentra por fecha, buscar la más cercana temporalmente
                if (!$consulta) {
                    $consulta = Consulta::where('Paciente_ID', $reservacion->Paciente_ID)
                        ->where('user_id', $reservacion->user_id)
                        ->orderByRaw('ABS(DATEDIFF(fecha_creacion, ?))', [$reservacion->fecha_consulta])
                        ->first();
                }

                // Opción 3: Fallback - la más reciente para esta combinación
                if (!$consulta) {
                    $consulta = Consulta::where('Paciente_ID', $reservacion->Paciente_ID)
                        ->where('user_id', $reservacion->user_id)
                        ->orderBy('fecha_creacion', 'desc')
                        ->first();
                }

                $consultaId = $consulta ? $consulta->Consulta_ID : null;

                $tipoConsulta = null;
                $consultaId = null;

                if ($consulta) {
                    $consultaId = $consulta->Consulta_ID; // Obtener el ID de la consulta

                    if ($consulta->Tipo_Consulta_ID) {
                        $tipoConsulta = Tipo_Consulta::find($consulta->Tipo_Consulta_ID);
                    }
                }

                // Formatear la fecha según el estado
                $fechaFormateada = $this->formatearFechaSegunEstado(
                    $reservacion->fecha_consulta,
                    $reservacion->estado_proximaConsulta
                );

                $consultasCompletas[] = [
                    'reservacion_id' => $reservacion->Reservacion_ID,
                    'consulta_id' => $consultaId, // Agregar consulta_id aquí
                    'paciente_id' => $reservacion->Paciente_ID,
                    'nutriologo_id' => $reservacion->user_id,
                    'nombre_nutriologo' => $reservacion->nombre_nutriologo,
                    'nombre_paciente' => $reservacion->nombre_paciente,
                    'estado_consulta' => $reservacion->estado_proximaConsulta,
                    'fecha_consulta' => $reservacion->fecha_consulta,
                    'fecha_formateada' => $fechaFormateada,
                    'foto_nutriologo' => $fotoNutriologo,
                    'foto_paciente' => $fotoPaciente, // Foto del paciente tal como está almacenada
                    'tipo_consulta' => $tipoConsulta ? $tipoConsulta->Nombre : 'No especificado',
                    'motivo_consulta' => $reservacion->motivoConsulta

                ];
            }

            return response()->json([
                'success' => true,
                'data' => $consultasCompletas,
                'message' => 'Consultas obtenidas exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener consultas: ' . $e->getMessage()
            ], 500);
        }
    }


    public function getConsultasPorPaciente3(Request $request)
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

            // Obtener las consultas para los pacientes y nutriólogos especificados
            $consultas = Consulta::whereIn('Paciente_ID', $pacienteIds)
                ->whereIn('user_id', $nutriologoIds)
                ->get();

            // Procesar cada consulta para agregar los datos adicionales
            $consultasCompletas = [];
            foreach ($consultas as $consulta) {
                // Obtener la foto del nutriólogo usando el user_id de la consulta
                $fotoNutriologo = Ajustes::where('user_id', $consulta->user_id)
                    ->value('foto');

                // Obtener la foto del paciente tal como está almacenada
                $fotoPaciente = Paciente::where('Paciente_ID', $consulta->Paciente_ID)
                    ->value('foto');

                $tipoConsulta = null;
                if ($consulta->Tipo_Consulta_ID) {
                    $tipoConsulta = Tipo_Consulta::find($consulta->Tipo_Consulta_ID);
                }

                // Construir el nombre completo del paciente desde la tabla consulta
                $nombreCompleto = trim($consulta->nombre_paciente . ' ' . $consulta->apellidos);

                $consultasCompletas[] = [
                    'consulta_id' => $consulta->Consulta_ID,
                    'fecha_creacion' => $consulta->fecha_creacion,
                    'paciente_id' => $consulta->Paciente_ID,
                    'nutriologo_id' => $consulta->user_id,
                    'nombre_nutriologo' => $consulta->nombre_nutriologo,
                    'nombre_paciente' => $nombreCompleto,
                    'foto_nutriologo' => $fotoNutriologo,
                    'foto_paciente' => $fotoPaciente,
                    'tipo_consulta' => $tipoConsulta ? $tipoConsulta->Nombre : 'No especificado'
                ];
            }

            return response()->json([
                'success' => true,
                'data' => $consultasCompletas,
                'message' => 'Consultas obtenidas exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener consultas: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getConsultasPorPaciente4(Request $request)
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

            // Obtener las consultas para los pacientes y nutriólogos especificados
            $consultas = Consulta::whereIn('Paciente_ID', $pacienteIds)
                ->whereIn('user_id', $nutriologoIds)
                ->get();

            // Agrupar consultas por nutriólogo
            $nutriologosData = [];

            foreach ($consultas as $consulta) {
                $nutriologoId = $consulta->user_id;

                // Si es la primera vez que procesamos este nutriólogo, inicializar su estructura
                if (!isset($nutriologosData[$nutriologoId])) {
                    // Obtener la foto del nutriólogo
                    $fotoNutriologo = Ajustes::where('user_id', $nutriologoId)
                        ->value('foto');

                    $nutriologosData[$nutriologoId] = [
                        'nutriologo_id' => $nutriologoId,
                        'nombre_nutriologo' => $consulta->nombre_nutriologo,
                        'foto_nutriologo' => $fotoNutriologo,
                        'paciente_id' => $consulta->Paciente_ID,

                        'consultas' => []
                    ];
                }

                // Obtener la foto del paciente
                $fotoPaciente = Paciente::where('Paciente_ID', $consulta->Paciente_ID)
                    ->value('foto');

                $tipoConsulta = null;
                if ($consulta->Tipo_Consulta_ID) {
                    $tipoConsulta = Tipo_Consulta::find($consulta->Tipo_Consulta_ID);
                }

                // Construir el nombre completo del paciente desde la tabla consulta
                $nombreCompleto = trim($consulta->nombre_paciente . ' ' . $consulta->apellidos);

                // Agregar la consulta al nutriólogo correspondiente
                $nutriologosData[$nutriologoId]['consultas'][] = [
                    'consulta_id' => $consulta->Consulta_ID,
                    'fecha_creacion' => $consulta->fecha_creacion,
                    'nombre_paciente' => $nombreCompleto,
                    'foto_paciente' => $fotoPaciente,
                    'tipo_consulta' => $tipoConsulta ? $tipoConsulta->Nombre : 'No especificado'
                ];
            }

            // Convertir el array asociativo a array indexado
            $resultado = array_values($nutriologosData);

            return response()->json([
                'success' => true,
                'data' => $resultado,
                'message' => 'Consultas obtenidas exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener consultas: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getGcMmPorConsulta(Request $request)
    {
        try {
            // Validar los parámetros de entrada
            $request->validate([
                'pacienteIds' => 'required|array',
                'pacienteIds.*' => 'integer',
                'nutriologoIds' => 'required|array',
                'nutriologoIds.*' => 'integer',
                'consultaIds' => 'required|array',
                'consultaIds.*' => 'integer'
            ]);

            $pacienteIds = $request->input('pacienteIds');
            $nutriologoIds = $request->input('nutriologoIds');
            $consultaIds = $request->input('consultaIds');

            // Obtener las consultas que coincidan con todos los criterios
            $consultas = Consulta::whereIn('Paciente_ID', $pacienteIds)
                ->whereIn('user_id', $nutriologoIds)
                ->whereIn('Consulta_ID', $consultaIds)
                ->select('Consulta_ID', 'Paciente_ID', 'user_id', 'gc', 'mm', 'nombre_paciente', 'apellidos', 'nombre_nutriologo')
                ->get();

            // Procesar las consultas para organizar los datos por paciente
            $resultadosPorPaciente = [];

            foreach ($consultas as $consulta) {
                $pacienteId = $consulta->Paciente_ID;
                $nombreCompleto = trim($consulta->nombre_paciente . ' ' . $consulta->apellidos);

                // Si el paciente no existe en el array, inicializarlo
                if (!isset($resultadosPorPaciente[$pacienteId])) {
                    $resultadosPorPaciente[$pacienteId] = [
                        'paciente_id' => $pacienteId,
                        'nombre_paciente' => $nombreCompleto,
                        'nutriologo_id' => $consulta->user_id,
                        'nombre_nutriologo' => $consulta->nombre_nutriologo,
                        'consultas' => []
                    ];
                }

                // Agregar los datos de GC y MM de esta consulta
                $resultadosPorPaciente[$pacienteId]['consultas'][] = [
                    'consulta_id' => $consulta->Consulta_ID,
                    'gc' => $consulta->gc,
                    'mm' => $consulta->mm
                ];
            }

            // Convertir el array asociativo a array indexado
            $datosFinales = array_values($resultadosPorPaciente);

            return response()->json([
                'success' => true,
                'data' => $datosFinales,
                'message' => 'Datos de GC y MM obtenidos exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener datos GC y MM: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getConsultasPorPaciente5(Request $request)
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

            // Obtener las consultas para los pacientes y nutriólogos especificados
            $consultas = Consulta::whereIn('Paciente_ID', $pacienteIds)
                ->whereIn('user_id', $nutriologoIds)
                ->select('Consulta_ID', 'Paciente_ID', 'user_id', 'fecha_creacion', 'Tipo_Consulta_ID',
                        'nombre_paciente', 'apellidos', 'nombre_nutriologo',
                        'peso', 'gc', 'mm', 'em', 'proteina', 'ec', 'me', 'gv', 'pg', 'gs', 'meq', 'bmr', 'ac', 'imc')
                ->get();

            // Agrupar consultas por nutriólogo
            $nutriologosData = [];

            foreach ($consultas as $consulta) {
                $nutriologoId = $consulta->user_id;

                // Si es la primera vez que procesamos este nutriólogo, inicializar su estructura
                if (!isset($nutriologosData[$nutriologoId])) {
                    // Obtener la foto del nutriólogo
                    $fotoNutriologo = Ajustes::where('user_id', $nutriologoId)
                        ->value('foto');

                    $nutriologosData[$nutriologoId] = [
                        'nutriologo_id' => $nutriologoId,
                        'paciente_id' => $consulta->Paciente_ID,
                        'nombre_nutriologo' => $consulta->nombre_nutriologo,
                        'foto_nutriologo' => $fotoNutriologo,
                        'consultas' => []
                    ];
                }

                // Obtener la foto del paciente
                $fotoPaciente = Paciente::where('Paciente_ID', $consulta->Paciente_ID)
                    ->value('foto');

                $tipoConsulta = null;
                if ($consulta->Tipo_Consulta_ID) {
                    $tipoConsulta = Tipo_Consulta::find($consulta->Tipo_Consulta_ID);
                }

                // Construir el nombre completo del paciente desde la tabla consulta
                $nombreCompleto = trim($consulta->nombre_paciente . ' ' . $consulta->apellidos);

                // Agregar la consulta al nutriólogo correspondiente
                $nutriologosData[$nutriologoId]['consultas'][] = [
                    'consulta_id' => $consulta->Consulta_ID,
                    'fecha_creacion' => $consulta->fecha_creacion,
                    'nombre_paciente' => $nombreCompleto,
                    'foto_paciente' => $fotoPaciente,
                    'tipo_consulta' => $tipoConsulta ? $tipoConsulta->Nombre : 'No especificado',
                    'peso' => $consulta->peso,
                    'gc' => $consulta->gc,
                    'mm' => $consulta->mm,
                    'em' => $consulta->em,
                    'proteina' => $consulta->proteina,
                    'ec' => $consulta->ec,
                    'me' => $consulta->me,
                    'gv' => $consulta->gv,
                    'pg' => $consulta->pg,
                    'gs' => $consulta->gs,
                    'meq' => $consulta->meq,
                    'bmr' => $consulta->bmr,
                    'ac' => $consulta->ac,
                    'imc' => $consulta->imc
                ];
            }

            // Convertir el array asociativo a array indexado
            $resultado = array_values($nutriologosData);

            return response()->json([
                'success' => true,
                'data' => $resultado,
                'message' => 'Consultas obtenidas exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener consultas: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getConsultasPorPaciente2(Request $request)
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

            // Obtener las reservaciones para los pacientes y nutriólogos especificados
            // Solo obtener las que tienen "Seguimiento:" en motivo_consulta y estado_proximaConsulta = 4
            $reservaciones = Reservaciones::whereIn('Paciente_ID', $pacienteIds)
                ->whereIn('user_id', $nutriologoIds)
                ->where('motivo_consulta', 'LIKE', '%Seguimiento:%')
                ->where('estado_proximaConsulta', 4)
                ->get();

            // Procesar cada reservación para agregar los datos adicionales
            $consultasCompletas = [];
            foreach ($reservaciones as $reservacion) {
                // Obtener la foto del nutriólogo
                $fotoNutriologo = Ajustes::where('user_id', $reservacion->user_id)
                    ->value('foto');

                // Obtener la foto del paciente tal como está almacenada
                $fotoPaciente = Paciente::where('Paciente_ID', $reservacion->Paciente_ID)
                    ->value('foto');

                // Buscar la consulta que corresponda a esta reservación específica
                // Opción 1: Buscar por fecha si ambas tablas tienen fechas similares
                $consulta = Consulta::where('Paciente_ID', $reservacion->Paciente_ID)
                    ->where('user_id', $reservacion->user_id)
                    ->whereDate('fecha_creacion', $reservacion->fecha_consulta->format('Y-m-d'))
                    ->first();

                // Opción 2: Si no encuentra por fecha, buscar la más cercana temporalmente
                if (!$consulta) {
                    $consulta = Consulta::where('Paciente_ID', $reservacion->Paciente_ID)
                        ->where('user_id', $reservacion->user_id)
                        ->orderByRaw('ABS(DATEDIFF(fecha_creacion, ?))', [$reservacion->fecha_consulta])
                        ->first();
                }

                // Opción 3: Fallback - la más reciente para esta combinación
                if (!$consulta) {
                    $consulta = Consulta::where('Paciente_ID', $reservacion->Paciente_ID)
                        ->where('user_id', $reservacion->user_id)
                        ->orderBy('fecha_creacion', 'desc')
                        ->first();
                }

                $consultaId = $consulta ? $consulta->Consulta_ID : null;

                $tipoConsulta = null;
                $consultaId = null;

                if ($consulta) {
                    $consultaId = $consulta->Consulta_ID; // Obtener el ID de la consulta

                    if ($consulta->Tipo_Consulta_ID) {
                        $tipoConsulta = Tipo_Consulta::find($consulta->Tipo_Consulta_ID);
                    }
                }

                // Formatear la fecha según el estado
                $fechaFormateada = $this->formatearFechaSegunEstado(
                    $reservacion->fecha_consulta,
                    $reservacion->estado_proximaConsulta
                );

                // Formatear la fecha_proximaConsulta si existe
                $fechaProximaConsultaFormateada = null;
                if ($reservacion->fecha_proximaConsulta) {
                    $fechaProximaConsultaFormateada = $this->formatearFechaSegunEstado(
                        $reservacion->fecha_proximaConsulta,
                        $reservacion->estado_proximaConsulta
                    );
                }

                $consultasCompletas[] = [
                    'reservacion_id' => $reservacion->Reservacion_ID,
                    'consulta_id' => $consultaId, // Agregar consulta_id aquí
                    'paciente_id' => $reservacion->Paciente_ID,
                    'nutriologo_id' => $reservacion->user_id,
                    'nombre_nutriologo' => $reservacion->nombre_nutriologo,
                    'nombre_paciente' => $reservacion->nombre_paciente,
                    'estado_consulta' => $reservacion->estado_proximaConsulta,
                    'fecha_consulta' => $reservacion->fecha_consulta,
                    'fecha_formateada' => $fechaFormateada,
                    'fecha_proxima_consulta' => $reservacion->fecha_proximaConsulta, // Campo agregado
                    'fecha_proxima_consulta_formateada' => $fechaProximaConsultaFormateada, // Campo agregado formateado
                    'foto_nutriologo' => $fotoNutriologo,
                    'foto_paciente' => $fotoPaciente, // Foto del paciente tal como está almacenada
                    'tipo_consulta' => $tipoConsulta ? $tipoConsulta->Nombre : 'No especificado',
                    'motivo_consulta' => $reservacion->motivo_consulta
                ];
            }

            return response()->json([
                'success' => true,
                'data' => $consultasCompletas,
                'message' => 'Consultas obtenidas exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener consultas: ' . $e->getMessage()
            ], 500);
        }
    }



    public function getConsultaIdsPorPaciente(Request $request)
    {
        try {
            // Validar los parámetros de entrada
            $request->validate([
                'pacienteId' => 'required|integer',
            ]);

            $pacienteId = $request->input('pacienteId');

            // Obtener todas las consultas asociadas al paciente
            $consultas = Consulta::where('Paciente_ID', $pacienteId)->get();

            // Extraer solo los IDs de consulta
            $consultaIds = $consultas->pluck('Consulta_ID')->toArray();

            return response()->json([
                'success' => true,
                'data' => [
                    'paciente_id' => $pacienteId,
                    'consulta_ids' => $consultaIds,
                    'total_consultas' => count($consultaIds)
                ],
                'message' => 'IDs de consultas obtenidos exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener IDs de consultas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener el detalle completo de una consulta específica
     *
     * @param  int  $consultaId
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDetalleConsulta($consultaId, Request $request)
    {
        try {
            $request->validate([
                'pacienteIds' => 'required|array',
                'pacienteIds.*' => 'integer',
            ]);

            $pacienteIds = $request->input('pacienteIds');

            // Obtener la consulta
            $consulta = Consulta::where('Consulta_ID', $consultaId)
                ->whereIn('Paciente_ID', $pacienteIds)
                ->first();

            if (!$consulta) {
                return response()->json([
                    'success' => false,
                    'message' => 'Consulta no encontrada'
                ], 404);
            }

            // Obtener la reservación asociada
            $reservacion = Reservaciones::where('Paciente_ID', $consulta->Paciente_ID)
                ->where('Reservacion_ID', $consulta->Reservacion_ID ?? 0)
                ->first();

            // Obtener el tipo de consulta
            $tipoConsulta = null;
            if ($consulta->Tipo_Consulta_ID) {
                $tipoConsulta = Tipo_Consulta::find($consulta->Tipo_Consulta_ID);
            }

            // Obtener la foto del nutriólogo
            $fotoNutriologo = null;
            if ($reservacion && $reservacion->user_id) {
                $fotoNutriologo = Ajustes::where('user_id', $reservacion->user_id)
                    ->value('foto');
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'consulta_id' => $consulta->Consulta_ID,
                    'consulta' => $consulta,
                    'reservacion' => $reservacion,
                    'tipo_consulta' => $tipoConsulta,
                    'foto_nutriologo' => $fotoNutriologo
                ],
                'message' => 'Detalle de consulta obtenido exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener detalle de consulta: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Formatear la fecha según el estado de la consulta
     *
     * @param  string  $fecha
     * @param  int  $estado
     * @return string
     */
    private function formatearFechaSegunEstado($fecha, $estado)
    {
        if (empty($fecha)) {
            return 'Fecha no definida';
        }

        try {
            $date = new \DateTime($fecha);

            switch ($estado) {
                case 1: // En progreso
                    $now = new \DateTime();
                    $diff = $date->diff($now);

                    if ($date > $now) {
                        return "Falta {$diff->days} días con {$diff->h} horas para su consulta";
                    } else {
                        return "Consulta en curso";
                    }

                case 2: // Próxima consulta
                    return $date->format('d/m/Y \a \l\a\s h:i A');

                case 3: // Realizado
                case 4: // En espera
                default:
                    return $date->format('d/m/Y');
            }
        } catch (\Exception $e) {
            return $fecha; // Devuelve la fecha original si hay error en el formato
        }
    }

        // Nuevo endpoint en tu API
    public function calcularTiempoRestante(Request $request)
    {
        $fechaConsulta = $request->input('fecha_consulta');

        if (empty($fechaConsulta)) {
            return response()->json([
                'success' => false,
                'message' => 'Fecha de consulta no proporcionada'
            ], 400);
        }

        try {
            $date = new \DateTime($fechaConsulta);
            $now = new \DateTime('now', new \DateTimeZone('UTC')); // Usar UTC para consistencia

            if ($date <= $now) {
                return response()->json([
                    'success' => true,
                    'data' => 'Consulta en curso'
                ]);
            }

            $diff = $date->diff($now);

            // Formatear diferencia de tiempo
            $message = $this->formatTimeDifference($diff);

            return response()->json([
                'success' => true,
                'data' => $message
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la fecha'
            ], 500);
        }
    }

    private function formatTimeDifference(\DateInterval $diff)
    {
        $parts = [];

        if ($diff->days > 0) {
            $parts[] = $diff->days . ' día(s)';
        }

        if ($diff->h > 0) {
            $parts[] = $diff->h . ' hora(s)';
        }

        if ($diff->i > 0 && $diff->days == 0) { // Solo mostrar minutos si es menos de 1 día
            $parts[] = $diff->i . ' minuto(s)';
        }

        return 'Falta ' . implode(' con ', $parts) . ' para su consulta';
    }
}
