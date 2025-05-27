<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Consulta;
use App\Models\Reservaciones;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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
                ->where('estado_proximaConsulta', '!=', 3) // Excluir realizadas
                ->select(
                    'Consulta_ID as id',
                    'nombre_paciente as title',
                    'proxima_consulta as start',
                    'estado_proximaConsulta',
                    'nombre_consultorio',
                    'direccion_consultorio'
                )
                ->get();

            // Aplicar el formato correcto para FullCalendar
            $eventos = $consultas->map(function ($consulta) {
                $className = $this->getColorByStatus($consulta->estado_proximaConsulta);
                return [
                    'id' => 'c_' . $consulta->id,
                    'title' => $consulta->title,
                    'start' => $consulta->start,
                    'className' => $className,
                    'nombre_consultorio' => $consulta->nombre_consultorio,
                    'direccion_consultorio' => $consulta->direccion_consultorio,
                    'estado_proximaConsulta' => $consulta->estado_proximaConsulta,
                    'type' => 'consulta'
                ];
            });

            // Obtener reservaciones (si existe la tabla)
            try {
                $reservaciones = Reservaciones::where('user_id', $user->id)
                    ->where('estado_proximaConsulta', '!=', 3) // Excluir realizadas
                    ->where('estado_proximaConsulta', '!=', 2)
                    ->where('estado_proximaConsulta', '!=', 0)
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
                        'id' => 'r_' . $reservacion->id,
                        'title' => $reservacion->title . ' ' . $reservacion->subtitle,
                        'start' => $reservacion->start,
                        'className' => $className,
                        'nombre_consultorio' => $reservacion->nombre_consultorio,
                        'direccion_consultorio' => $reservacion->direccion_consultorio,
                        'estado_proximaConsulta' => $reservacion->estado_proximaConsulta,
                        'type' => 'reservacion'
                    ];
                });

                // Combinar ambos arrays de eventos
                $eventos = $eventos->concat($eventosReservaciones);
            } catch (\Exception $e) {
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
            $limite = $request->input('limit', 30);

            // Obtener próximas consultas
            $consultas = Consulta::where('user_id', $user->id)
                ->whereNotNull('proxima_consulta')
                ->where('proxima_consulta', '>=', $ahora)
                ->where('estado', true)
                ->where('estado_proximaConsulta', '!=', 3)
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
                    'title' => $consulta->title . ' ' . $consulta->subtitle,
                    'start' => $consulta->start,
                    'className' => $className,
                    'nombre_consultorio' => $consulta->nombre_consultorio,
                    'direccion_consultorio' => $consulta->direccion_consultorio,
                    'type' => 'consulta',
                    'estado_proximaConsulta' => $consulta->estado_proximaConsulta
                ];
            });

            // Obtener próximas reservaciones
            try {
                $reservaciones = Reservaciones::where('user_id', $user->id)
                    ->where('fecha_consulta', '>=', $ahora)
                    ->where('estado_proximaConsulta', '!=', 3)
                    ->where('estado_proximaConsulta', '!=', 2)
                    ->where('estado_proximaConsulta', '!=', 0)
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
                        'title' => $reservacion->title . ' ' . $reservacion->subtitle,
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
                    'motivo_consulta' => $reservacion->motivo_consulta,
                    'precio_cita' => $reservacion->precio_cita,
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
    public function actualizarReservacion(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $reservacion = Reservaciones::findOrFail($id);
            $estadoAnterior = $reservacion->estado_proximaConsulta;

            $validated = $request->validate([
                'nombre_consultorio' => 'required_if:estado_proximaConsulta,1|string|max:255',
                'direccion_consultorio' => 'required_if:estado_proximaConsulta,1|string|max:500',
                'fecha_proximaConsulta' => 'nullable|date',
                'estado_proximaConsulta' => 'required|integer|in:0,1,2,3,4',
                'origen' => 'sometimes|string|in:web,movil'
            ]);

            // CASO 1: Cambio de estado 1 (en progreso) a estado 2 (próxima consulta)
            if ($validated['estado_proximaConsulta'] == 2 && $estadoAnterior == 1) {
                if (empty($validated['fecha_proximaConsulta'])) {
                    throw new \Exception("Se requiere fecha para próxima consulta al completar");
                }

                $reservacion->estado_proximaConsulta = 3; // Cambio a estado 3 (ocultar)
                $reservacion->fill($validated);
                $reservacion->origen = 'web';
                $reservacion->save();

                $nuevaReservacion = $this->crearReservacionSeguimiento($reservacion);
                $nuevaReservacion->estado_proximaConsulta = 4;
                $nuevaReservacion->save();

                $reservacion->crearNotificacion('completado');
                $nuevaReservacion->crearNotificacion('seguimiento');

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Cita completada y nueva cita de seguimiento creada',
                    'data' => [
                        'original' => $reservacion,
                        'nueva' => $nuevaReservacion
                    ]
                ]);
            }

            // CASO 2: Cambio de estado 2 a 3 con creación de nueva reservación
            if ($validated['estado_proximaConsulta'] == 3 && $estadoAnterior == 2) {
                $reservacion->fill($validated);
                $reservacion->origen = 'web';
                $reservacion->save();

                // Solo crear nueva reservación si hay fecha próxima
                $nuevaReservacion = null;
                if (!empty($validated['fecha_proximaConsulta'])) {
                    $nuevaReservacion = $this->crearReservacionSeguimiento($reservacion);
                    $nuevaReservacion->estado_proximaConsulta = 4;
                    $nuevaReservacion->save();
                    $nuevaReservacion->crearNotificacion('nueva');
                }

                $reservacion->crearNotificacion('reagendado');

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Cita actualizada y nueva cita creada',
                    'data' => [
                        'original' => $reservacion,
                        'nueva' => $nuevaReservacion
                    ]
                ]);
            }

            // CASO 3: Cuando la reservación está en estado 2 y se mantiene en 2 (crear nueva y ocultar anterior)
            if ($validated['estado_proximaConsulta'] == 2 && $estadoAnterior == 2) {
                $reservacion->estado_proximaConsulta = 3; // Cambiar la anterior a estado 3
                $reservacion->fill($validated);
                $reservacion->save();

                // Crear nueva reservación si hay fecha próxima
                $nuevaReservacion = null;
                if (!empty($validated['fecha_proximaConsulta'])) {
                    $nuevaReservacion = $this->crearReservacionSeguimiento($reservacion);
                    $nuevaReservacion->estado_proximaConsulta = 4;
                    $nuevaReservacion->save();
                    $nuevaReservacion->crearNotificacion('nueva');
                }

                $reservacion->crearNotificacion('actualización');

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Cita actualizada y nueva cita creada',
                    'data' => [
                        'original' => $reservacion,
                        'nueva' => $nuevaReservacion
                    ]
                ]);
            }

            // CASO GENERAL: Actualización normal sin cambios especiales
            $reservacion->fill($validated);
            $reservacion->origen = 'web';
            $reservacion->save();
            $reservacion->crearNotificacion('actualización');

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => $reservacion
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error actualizando reservación: " . $e->getMessage());
            return response()->json([
                'error' => 'Error al actualizar',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function crearReservacionSeguimiento(Reservaciones $original)
    {
        $original->estado_proximaConsulta = 3;
        $original->save();
        // Verificar si el motivo ya comienza con "Seguimiento: "
        $motivoConsulta = $original->motivo_consulta;
        if (!str_starts_with($motivoConsulta, "Seguimiento: ")) {
            $motivoConsulta = "Seguimiento: " . $motivoConsulta;
        }
        return Reservaciones::create([
            'user_id' => $original->user_id,
            'Paciente_ID' => $original->Paciente_ID,
            'Consulta_ID' => $original->Consulta_ID,
            'nombre_paciente' => $original->nombre_paciente,
            'apellidos' => $original->apellidos,
            'telefono' => $original->telefono,
            'genero' => $original->genero,
            'usuario' => $original->usuario,
            'edad' => $original->edad,
            'precio_cita' => $original->precio_cita,
            'motivo_consulta' =>$motivoConsulta,
            'nombre_consultorio' => $original->nombre_consultorio,
            'direccion_consultorio' => $original->direccion_consultorio,
            'nombre_nutriologo' => $original->nombre_nutriologo,
            'fecha_consulta' => $original->fecha_proximaConsulta,
            'fecha_proximaConsulta' => null,
            'estado_proximaConsulta' => 4, // "En espera" por defecto
            'origen' => 'web',
            'Ultima_Notificacion_ID' => null
        ]);
    }

    public function crearReservacionDesdeExistente(Request $request)
    {
        // Verificar autenticación
        $user = $this->getUserFromToken($request);
        if (!$user) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        try {
            // Validar datos de entrada
            $validatedData = $request->validate([
                'Consulta_ID' => 'nullable|integer|exists:consultas,Consulta_ID',
                'Paciente_ID' => 'nullable|integer|exists:pacientes,Paciente_ID',
                'nombre_paciente' => 'required|string|max:255',
                'apellidos' => 'required|string|max:255',
                'telefono' => 'required|string|max:20',
                'email' => 'nullable|email|max:255',
                'genero' => 'required|string|in:Masculino,Femenino,Otro',
                'usuario' => 'required|string|max:50',
                'edad' => 'required|integer|min:0|max:120',
                'fecha_nacimiento' => 'nullable|date',
                'fecha_consulta' => 'required|date',
                'nombre_consultorio' => 'nullable|string|max:255',
                'direccion_consultorio' => 'nullable|string|max:500',
                'motivo_consulta' => 'required|string|max:1000',
                'precio_cita' => 'required|numeric|min:0',
                'fecha_proximaConsulta' => 'nullable|date',
                'nombre_nutriologo' => 'required|string|max:255',
                'estado_proximaConsulta' => 'required|integer|in:2', // Solo permitir estado 2
                'enfermedad' => 'nullable|string|max:255',
                'localidad' => 'nullable|string|max:100',
                'ciudad' => 'nullable|string|max:100',
                'origen' => 'required|string|max:50'
            ]);

            // Convertir fechas a formato correcto
            $validatedData['fecha_consulta'] = Carbon::parse($validatedData['fecha_consulta'])->format('Y-m-d H:i:s');

            if (isset($validatedData['fecha_proximaConsulta'])) {
                $validatedData['fecha_proximaConsulta'] = Carbon::parse($validatedData['fecha_proximaConsulta'])->format('Y-m-d H:i:s');
            }

            // Crear nueva reservación
            $reservacion = new Reservaciones();
            $reservacion->fill($validatedData);
            $reservacion->user_id = $user->id;
            $reservacion->Notificacion_ID = null; // Nueva notificación
            $reservacion->save();

            // Devolver respuesta exitosa
            return response()->json([
                'status' => 'success',
                'message' => 'Nueva reservación creada correctamente',
                'data' => $reservacion
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Manejar errores de validación
            return response()->json([
                'error' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Error general
            Log::error('Error al crear reservación desde existente: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error al crear la reservación',
                'details' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
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


    /**
     * Crear una nueva reservación
     */
    public function crearReservacion(Request $request)
    {
        // Obtener el usuario autenticado
        $user = $this->getUserFromToken($request);
        if (!$user) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        // Validar los datos de entrada (sin Notificacion_ID)
        $validatedData = $request->validate([
            'Consulta_ID' => 'nullable|integer',
            'Paciente_ID' => 'nullable|integer',
            'nombre_paciente' => 'required|string',
            'apellidos' => 'required|string',
            'telefono' => 'required|string',
            'genero' => 'required|string',
            'usuario' => 'required|string',
            'edad' => 'required|integer',
            'precio_cita' => 'required|numeric',
            'motivo_consulta' => 'required|string',
            'nombre_consultorio' => 'nullable|string',
            'direccion_consultorio' => 'nullable|string',
            'nombre_nutriologo' => 'required|string',
            'fecha_consulta' => 'required|date',
            'fecha_proximaConsulta' => 'nullable|date',
            'estado_proximaConsulta' => 'required|integer|in:0,1,2,3,4',
            'origen' => 'required|string|in:movil,web'
        ]);

        DB::beginTransaction();

        try {
            // Crear la reservación sin disparar eventos
            $reservacion = Reservaciones::withoutEvents(function () use ($validatedData, $user) {
                return Reservaciones::create([
                    'user_id' => $user->id,
                    'Consulta_ID' => $validatedData['Consulta_ID'] ?? null,
                    'Paciente_ID' => $validatedData['Paciente_ID'] ?? null,
                    'nombre_paciente' => $validatedData['nombre_paciente'],
                    'apellidos' => $validatedData['apellidos'],
                    'telefono' => $validatedData['telefono'],
                    'genero' => $validatedData['genero'],
                    'usuario' => $validatedData['usuario'],
                    'edad' => $validatedData['edad'],
                    'precio_cita' => $validatedData['precio_cita'],
                    'motivo_consulta' => $validatedData['motivo_consulta'],
                    'nombre_consultorio' => $validatedData['nombre_consultorio'] ?? null,
                    'direccion_consultorio' => $validatedData['direccion_consultorio'] ?? null,
                    'nombre_nutriologo' => $validatedData['nombre_nutriologo'],
                    'fecha_consulta' => $validatedData['fecha_consulta'],
                    'fecha_proximaConsulta' => $validatedData['fecha_proximaConsulta'] ?? null,
                    'estado_proximaConsulta' => $validatedData['estado_proximaConsulta'],
                    'origen' => $validatedData['origen']
                ]);
            });

            // Crear UNA sola notificación manualmente
            $reservacion->crearNotificacion('creación');

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Reservación creada correctamente',
                'data' => $reservacion
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Error de validación',
                'details' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear reservación: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error al crear la reservación',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}
