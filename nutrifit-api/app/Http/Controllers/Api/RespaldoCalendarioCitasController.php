<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Consulta;
use App\Models\Reservacion;
use App\Models\Reservaciones;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class CalendarioCitasController extends Controller
{
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
     * Obtener todas las consultas y reservaciones para el calendario
     */
    public function getEventos(Request $request)
    {
        // Obtener el usuario autenticado
        $user = $this->getUserFromToken($request);
        if (!$user) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        try {
            // Obtener consultas (con próxima consulta programada)
            $consultas = Consulta::where('user_id', $user->id)
                ->whereNotNull('proxima_consulta')
                ->where('estado', true)
                ->select(
                    'Consulta_ID as id',
                    'nombre_paciente as title',
                    'proxima_consulta as start',
                    'estado_proximaConsulta', // 0:Cancelado, 1:En Progreso, 2:Próxima Consulta, 3:Realizado, 4:En Espera
                    'nombre_consultorio',
                    'direccion_consultorio'
                )
                ->get();

            // Aplicar el formato correcto para FullCalendar
            $eventos = $consultas->map(function ($consulta) {
                $className = $this->getColorByStatus($consulta->estado_proximaConsulta);
                return [
                    'id' => 'c_' . $consulta->id, // Prefijo para identificar que es una consulta
                    'title' => $consulta->title,
                    'start' => $consulta->start,
                    'className' => $className,
                    'nombre_consultorio' => $consulta->nombre_consultorio,
                    'direccion_consultorio' => $consulta->direccion_consultorio,
                    'estado_proximaConsulta' => $consulta->estado_proximaConsulta,
                    'type' => 'consulta' // Identificar tipo de evento
                ];
            });

            // Obtener reservaciones (si existe la tabla)
            try {
                $reservaciones = Reservaciones::where('user_id', $user->id)
                    ->where('estado', true)
                    ->select(
                        'Reservacion_ID as id',
                        'nombre_paciente as title',
                        'apellidos as subtitle',
                        'fecha_consulta as start',
                        'estado_proximaConsulta',
                        'nombre_consultorio',
                        'direccion_consultorio'
                    )
                    ->get();

                // Aplicar el formato correcto para FullCalendar
                $eventosReservaciones = $reservaciones->map(function ($reservacion) {
                    $className = $this->getColorByStatus($reservacion->estado_proximaConsulta);
                    return [
                        'id' => 'r_' . $reservacion->id, // Prefijo para identificar que es una reservación
                        'title' => $reservacion->title,
                        'subtitle' => $reservacion->subtitle,
                        'start' => $reservacion->start,
                        'className' => $className,
                        'nombre_consultorio' => $reservacion->nombre_consultorio,
                        'direccion_consultorio' => $reservacion->direccion_consultorio,
                        'estado_proximaConsulta' => $reservacion->estado_proximaConsulta,
                        'type' => 'reservacion' // Identificar tipo de evento
                    ];
                });

                // Combinar ambos arrays de eventos
                $eventos = $eventos->concat($eventosReservaciones);
            } catch (\Exception $e) {
                // Si la tabla de reservaciones no existe o hay otro error, continuamos solo con consultas
                Log::warning('Error al obtener reservaciones: ' . $e->getMessage());
            }

            return response()->json($eventos);
        } catch (\Exception $e) {
            Log::error('Error al obtener eventos del calendario: ' . $e->getMessage());
            return response()->json(['error' => 'Error al cargar eventos'], 500);
        }
    }

    /**
     * Obtener próximas consultas y reservaciones (limitado a N elementos)
     */
    public function getProximosEventos(Request $request)
    {
        // Obtener el usuario autenticado
        $user = $this->getUserFromToken($request);
        if (!$user) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        try {
            $ahora = now();
            $limite = $request->input('limit', 20); // Limitar a 10 eventos por defecto

            // Obtener próximas consultas - MODIFICADO: incluir todas las consultas con fecha futura
            $consultas = Consulta::where('user_id', $user->id)
                ->whereNotNull('proxima_consulta')
                ->where('proxima_consulta', '>=', $ahora)
                ->where('estado', true)
                // Eliminamos filtros de estado para traer todas las consultas
                ->select(
                    'Consulta_ID as id',
                    'nombre_paciente as title',
                    'apellidos as subtitle',
                    'proxima_consulta as start',
                    'estado_proximaConsulta',
                    'nombre_consultorio',
                    'direccion_consultorio'
                )
                ->orderBy('proxima_consulta')
                ->get();

            // Aplicar el formato correcto
            $eventos = $consultas->map(function ($consulta) {
                $className = $this->getColorByStatus($consulta->estado_proximaConsulta);
                return [
                    'id' => 'c_' . $consulta->id,
                    'title' => $consulta->title,
                    'subtitle' => $consulta->subtitle,
                    'start' => $consulta->start,
                    'className' => $className,
                    'nombre_consultorio' => $consulta->nombre_consultorio,
                    'direccion_consultorio' => $consulta->direccion_consultorio,
                    'type' => 'consulta',
                    'estado_proximaConsulta' => $consulta->estado_proximaConsulta
                ];
            });

            // Obtener próximas reservaciones (si existe la tabla)
            try {
                $reservaciones = Reservaciones::where('user_id', $user->id)
                    ->where('fecha_consulta', '>=', $ahora)
                    ->where('estado', true)
                    // Eliminamos filtros de estado para traer todas las reservaciones
                    ->select(
                        'Reservacion_ID as id',
                        'nombre_paciente as title',
                        'apellidos as subtitle',
                        'fecha_consulta as start',
                        'estado_proximaConsulta',
                        'nombre_consultorio',
                        'direccion_consultorio'
                    )
                    ->orderBy('fecha_consulta')
                    ->get();

                // Aplicar el formato correcto
                $eventosReservaciones = $reservaciones->map(function ($reservacion) {
                    $className = $this->getColorByStatus($reservacion->estado_proximaConsulta);
                    return [
                        'id' => 'r_' . $reservacion->id,
                        'title' => $reservacion->title,
                        'subtitle' => $reservacion->subtitle,

                        'start' => $reservacion->start,
                        'className' => $className,
                        'nombre_consultorio' => $reservacion->nombre_consultorio,
                        'direccion_consultorio' => $reservacion->direccion_consultorio,
                        'type' => 'reservacion',
                        'estado_proximaConsulta' => $reservacion->estado_proximaConsulta
                    ];
                });

                // Combinar ambos arrays
                $eventos = $eventos->concat($eventosReservaciones);
            } catch (\Exception $e) {
                // Si la tabla de reservaciones no existe o hay otro error, continuamos solo con consultas
                Log::warning('Error al obtener reservaciones próximas: ' . $e->getMessage());
            }

            // Ordenar por fecha y limitar al número solicitado
            $eventos = $eventos->sortBy('start')->values()->take($limite);

            return response()->json($eventos);
        } catch (\Exception $e) {
            Log::error('Error al obtener próximos eventos: ' . $e->getMessage());
            return response()->json(['error' => 'Error al cargar eventos próximos: ' . $e->getMessage()], 500);
        }
    }
    /**
     * Obtener detalles de un evento específico (consulta o reservación)
     */
    public function getEventoDetalle(Request $request, $id)
    {
        // Obtener el usuario autenticado
        $user = $this->getUserFromToken($request);
        if (!$user) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        try {
            // Determinar si es consulta o reservación por el prefijo
            $parts = explode('_', $id);
            $tipo = $parts[0] ?? '';
            $eventoId = $parts[1] ?? $id; // Si no hay prefijo, usar el ID completo

            if ($tipo === 'c') {
                // Es una consulta
                $consulta = Consulta::where('Consulta_ID', $eventoId)
                    ->where('user_id', $user->id)
                    ->first();

                if (!$consulta) {
                    return response()->json(['error' => 'Consulta no encontrada'], 404);
                }

                // Obtener detalles adicionales del paciente si es necesario
                $paciente = \App\Models\Paciente::where('Paciente_ID', $consulta->Paciente_ID)->first();

                return response()->json([
                    'id' => 'c_' . $consulta->Consulta_ID,
                    'nombre_paciente' => $consulta->nombre_paciente,
                    'apellidos' => $consulta->apellidos,
                    'email' => $consulta->email,
                    'telefono' => $consulta->telefono,
                    'genero' => $consulta->genero,
                    'usuario' => $consulta->usuario,
                    'enfermedad' => $consulta->enfermedad,
                    'localidad' => $consulta->localidad,
                    'ciudad' => $consulta->ciudad,
                    'edad' => $consulta->edad,
                    'fecha_nacimiento' => $consulta->fecha_nacimiento,
                    'fecha_consulta' => $consulta->proxima_consulta,
                    'nombre_consultorio' => $consulta->nombre_consultorio,
                    'direccion_consultorio' => $consulta->direccion_consultorio,
                    'nombre_nutriologo' => $consulta->nombre_nutriologo,
                    'fecha_proximaConsulta' => $consulta->fecha_proximaConsulta,
                    'estado_proximaConsulta' => $consulta->estado_proximaConsulta,
                    'type' => 'consulta'
                ]);
            } else if ($tipo === 'r') {
                // Es una reservación
                $reservacion = Reservaciones::where('Reservacion_ID', $eventoId)
                    ->where('user_id', $user->id)
                    ->first();

                if (!$reservacion) {
                    return response()->json(['error' => 'Reservación no encontrada'], 404);
                }

                return response()->json([
                    'id' => 'r_' . $reservacion->Reservacion_ID,
                    'nombre_paciente' => $reservacion->nombre_paciente,
                    'apellidos' => $reservacion->apellidos,
                    'email' => $reservacion->email,
                    'telefono' => $reservacion->telefono,
                    'genero' => $reservacion->genero,
                    'usuario' => $reservacion->usuario,
                    'enfermedad' => $reservacion->enfermedad,
                    'localidad' => $reservacion->localidad,
                    'ciudad' => $reservacion->ciudad,
                    'edad' => $reservacion->edad,
                    'fecha_nacimiento' => $reservacion->fecha_nacimiento,
                    'fecha_consulta' => $reservacion->fecha_consulta,
                    'nombre_consultorio' => $reservacion->nombre_consultorio,
                    'direccion_consultorio' => $reservacion->direccion_consultorio,
                    'nombre_nutriologo' => $reservacion->nombre_nutriologo,
                    'fecha_proximaConsulta' => $reservacion->fecha_proximaConsulta,

                    'estado_proximaConsulta' => $reservacion->estado_proximaConsulta,
                    'type' => 'reservacion'
                ]);
            } else {
                // Intentar buscar en ambas tablas si no hay prefijo claro
                $consulta = Consulta::where('Consulta_ID', $id)
                    ->where('user_id', $user->id)
                    ->first();

                if ($consulta) {
                    return response()->json([
                        'id' => 'c_' . $consulta->Consulta_ID,
                        'nombre_paciente' => $consulta->nombre_paciente,
                        'apellidos' => $consulta->apellidos,
                        'email' => $consulta->email,
                        'telefono' => $consulta->telefono,
                        'genero' => $consulta->genero,
                        'usuario' => $consulta->usuario,
                        'enfermedad' => $consulta->enfermedad,
                        'localidad' => $consulta->localidad,
                        'ciudad' => $consulta->ciudad,
                        'edad' => $consulta->edad,
                        'fecha_nacimiento' => $consulta->fecha_nacimiento,
                        'fecha_consulta' => $consulta->proxima_consulta,
                        'nombre_consultorio' => $consulta->nombre_consultorio,
                        'direccion_consultorio' => $consulta->direccion_consultorio,
                        'nombre_nutriologo' => $consulta->nombre_nutriologo,
                        'fecha_proximaConsulta' => $consulta->fecha_proximaConsulta,

                        'estado_proximaConsulta' => $consulta->estado_proximaConsulta,
                        'type' => 'consulta'
                    ]);
                }

                $reservacion = Reservaciones::where('Reservacion_ID', $id)
                    ->where('user_id', $user->id)
                    ->first();

                if ($reservacion) {
                    return response()->json([
                        'id' => 'r_' . $reservacion->Reservacion_ID,
                        'nombre_paciente' => $reservacion->nombre_paciente,
                        'apellidos' => $reservacion->apellidos,
                        'email' => $reservacion->email,
                        'telefono' => $reservacion->telefono,
                        'genero' => $reservacion->genero,
                        'usuario' => $reservacion->usuario,
                        'enfermedad' => $reservacion->enfermedad,
                        'localidad' => $reservacion->localidad,
                        'ciudad' => $reservacion->ciudad,
                        'edad' => $reservacion->edad,
                        'fecha_nacimiento' => $reservacion->fecha_nacimiento,
                        'fecha_consulta' => $reservacion->fecha_consulta,
                        'nombre_consultorio' => $reservacion->nombre_consultorio,
                        'direccion_consultorio' => $reservacion->direccion_consultorio,
                        'nombre_nutriologo' => $reservacion->nombre_nutriologo,
                        'fecha_proximaConsulta' => $reservacion->fecha_proximaConsulta,

                        'estado_proximaConsulta' => $reservacion->estado_proximaConsulta,
                        'type' => 'reservacion'
                    ]);
                }

                return response()->json(['error' => 'Evento no encontrado'], 404);
            }
        } catch (\Exception $e) {
            Log::error('Error al obtener detalle del evento: ' . $e->getMessage());
            return response()->json(['error' => 'Error al cargar detalle del evento'], 500);
        }
    }

    /**
     * Actualizar un evento (consulta o reservación)
     */
    public function actualizarEvento(Request $request, $id)
    {
        // Obtener el usuario autenticado
        $user = $this->getUserFromToken($request);
        if (!$user) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        try {
            // Determinar si es consulta o reservación por el prefijo
            $parts = explode('_', $id);
            $tipo = $parts[0] ?? '';
            $eventoId = $parts[1] ?? $id; // Si no hay prefijo, usar el ID completo

            if ($tipo === 'c') {
                // Actualizar consulta
                $consulta = Consulta::where('Consulta_ID', $eventoId)
                    ->where('user_id', $user->id)
                    ->first();

                if (!$consulta) {
                    return response()->json(['error' => 'Consulta no encontrada'], 404);
                }

                // Actualizar los campos de la consulta
                if ($request->has('fecha_consulta')) {
                    $consulta->proxima_consulta = $request->fecha_consulta;
                }

                if ($request->has('estado_proximaConsulta')) {
                    $consulta->estado_proximaConsulta = $request->estado_proximaConsulta;
                }

                if ($request->has('nombre_consultorio')) {
                    $consulta->nombre_consultorio = $request->nombre_consultorio;
                }

                if ($request->has('direccion_consultorio')) {
                    $consulta->direccion_consultorio = $request->direccion_consultorio;
                }

                $consulta->save();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Consulta actualizada correctamente',
                    'data' => $consulta
                ]);
            } else if ($tipo === 'r') {
                // Actualizar reservación
                $reservacion = Reservaciones::where('Reservacion_ID', $eventoId)
                    ->where('user_id', $user->id)
                    ->first();

                if (!$reservacion) {
                    return response()->json(['error' => 'Reservación no encontrada'], 404);
                }

                // Actualizar los campos de la reservación
                if ($request->has('fecha_consulta')) {
                    $reservacion->fecha_consulta = $request->fecha_consulta;
                }

                if ($request->has('estado_proximaConsulta')) {
                    $reservacion->estado_proximaConsulta = $request->estado_proximaConsulta;
                }

                if ($request->has('nombre_consultorio')) {
                    $reservacion->nombre_consultorio = $request->nombre_consultorio;
                }

                if ($request->has('direccion_consultorio')) {
                    $reservacion->direccion_consultorio = $request->direccion_consultorio;
                }

                $reservacion->save();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Reservación actualizada correctamente',
                    'data' => $reservacion
                ]);
            } else {
                // Intentar buscar en ambas tablas si no hay prefijo claro
                $consulta = Consulta::where('Consulta_ID', $id)
                    ->where('user_id', $user->id)
                    ->first();

                if ($consulta) {
                    // Actualizar consulta
                    if ($request->has('fecha_consulta')) {
                        $consulta->proxima_consulta = $request->fecha_consulta;
                    }

                    if ($request->has('estado_proximaConsulta')) {
                        $consulta->estado_proximaConsulta = $request->estado_proximaConsulta;
                    }

                    if ($request->has('nombre_consultorio')) {
                        $consulta->nombre_consultorio = $request->nombre_consultorio;
                    }

                    if ($request->has('direccion_consultorio')) {
                        $consulta->direccion_consultorio = $request->direccion_consultorio;
                    }

                    $consulta->save();

                    return response()->json([
                        'status' => 'success',
                        'message' => 'Consulta actualizada correctamente',
                        'data' => $consulta
                    ]);
                }

                $reservacion = Reservaciones::where('Reservacion_ID', $id)
                    ->where('user_id', $user->id)
                    ->first();

                if ($reservacion) {
                    // Actualizar reservación
                    if ($request->has('fecha_consulta')) {
                        $reservacion->fecha_consulta = $request->fecha_consulta;
                    }

                    if ($request->has('estado_proximaConsulta')) {
                        $reservacion->estado_proximaConsulta = $request->estado_proximaConsulta;
                    }

                    if ($request->has('nombre_consultorio')) {
                        $reservacion->nombre_consultorio = $request->nombre_consultorio;
                    }

                    if ($request->has('direccion_consultorio')) {
                        $reservacion->direccion_consultorio = $request->direccion_consultorio;
                    }

                    $reservacion->save();

                    return response()->json([
                        'status' => 'success',
                        'message' => 'Reservación actualizada correctamente',
                        'data' => $reservacion
                    ]);
                }

                return response()->json(['error' => 'Evento no encontrado'], 404);
            }
        } catch (\Exception $e) {
            Log::error('Error al actualizar evento: ' . $e->getMessage());
            return response()->json(['error' => 'Error al actualizar el evento', 'details' => $e->getMessage()], 500);
        }
    }

    /**
     * Obtener el color de la clase CSS según el estado de la cita
     */
    private function getColorByStatus($status)
    {
        switch ($status) {
            case 0:
                return 'bg-danger-subtle'; // Cancelado
            case 1:
                return 'bg-success-subtle'; // En Progreso
            case 2:
                return 'bg-primary-subtle'; // Próxima Consulta
            case 3:
                return 'bg-info-subtle'; // Realizado
            case 4:
                return 'bg-warning-subtle'; // En Espera
            default:
                return 'bg-secondary-subtle';
        }
    }
}
