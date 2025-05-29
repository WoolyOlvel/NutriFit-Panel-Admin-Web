<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ajustes;
use App\Models\Consulta;
use App\Models\Paciente;
use App\Models\Reservaciones;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function getDashboardData(Request $request)
    {
        $user = $this->getUserFromToken($request);
        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        $data = [
            'nombre_nutriologo' => $this->getNombreNutriologo($user),
            'pacientes' => $this->getPacientesStats($user),
            'citas' => $this->getCitasStats($user),
            'planes_alimentacion' => $this->getPlanesAlimentacionStats($user),
            'chats' => $this->getChatsStats(),
            'grafica_resumen' => $this->getGraficaResumenData($user, $request->input('periodo', '1Y')),
            'pacientes_recientes' => $this->getPacientesRecientes($user),
            'pacientes_subsecuentes' => $this->getPacientesSubsecuentes($user, $request->input('page', 1)),
            'porcentaje_por_edad' => $this->getPorcentajePorEdad($user),
            'porcentaje_por_enfermedad' => $this->getPorcentajePorEnfermedad($user),
            'consultas_recientes' => $this->getConsultasRecientes($user)

        ];

        return response()->json($data);
    }

    private function getNombreNutriologo($user)
    {
        $ajuste = Ajustes::where('user_id', $user->id)->first();
        return $ajuste ? $ajuste->nombre_nutriologo : 'Nutriólogo';
    }

    private function getPacientesStats($user)
    {
        $totalPacientes = Paciente::where('user_id', $user->id)
            ->where('status', 1)
            ->count();

        $pacientesInactivos = Paciente::where('user_id', $user->id)
            ->where('status', 0)
            ->count();

        $totalRegistros = $totalPacientes + $pacientesInactivos;
        $porcentaje = 0;

        if ($totalRegistros > 0) {
            $porcentaje = ($totalPacientes / $totalRegistros) * 100;
            $porcentaje = round($porcentaje - 100, 2);
        }

        return [
            'total' => $totalPacientes,
            'porcentaje' => $porcentaje,
            'tendencia' => $porcentaje >= 0 ? 'up' : 'down'
        ];
    }

    private function getCitasStats($user)
    {
        $citasActivas = Reservaciones::where('user_id', $user->id)
            ->whereIn('estado_proximaConsulta', [3, 4])
            ->count();

        $citasCanceladas = Reservaciones::where('user_id', $user->id)
            ->where('estado_proximaConsulta', 0)
            ->count();

        $totalRegistros = $citasActivas + $citasCanceladas;
        $porcentaje = 0;

        if ($totalRegistros > 0) {
            $porcentaje = ($citasActivas / $totalRegistros) * 100;
            $porcentaje = round($porcentaje - 100, 2);
        }

        return [
            'total' => $citasActivas,
            'porcentaje' => $porcentaje,
            'tendencia' => $porcentaje >= 0 ? 'up' : 'down'
        ];
    }

    private function getPlanesAlimentacionStats($user)
    {
        $consultas = Consulta::where('user_id', $user->id)->get();
        $totalPlanes = 0;
        $consultasConPlan = 0;
        $consultasSinPlan = 0;

        foreach ($consultas as $consulta) {
            if (!empty($consulta->plan_nutricional_path)) {
                $planes = json_decode($consulta->plan_nutricional_path, true);
                $totalPlanes += is_array($planes) ? count($planes) : 1;
                $consultasConPlan++;
            } else {
                $consultasSinPlan++;
            }
        }

        $totalConsultas = $consultasConPlan + $consultasSinPlan;
        $porcentaje = 0;

        if ($totalConsultas > 0) {
            $porcentaje = ($consultasConPlan / $totalConsultas) * 100;
            $porcentaje = round($porcentaje - 100, 2);
        }

        return [
            'total' => $totalPlanes,
            'porcentaje' => $porcentaje,
            'tendencia' => $porcentaje >= 0 ? 'up' : 'down'
        ];
    }

    private function getChatsStats()
    {
        return [
            'total' => 0,
            'porcentaje' => 2.0,
            'tendencia' => 'neutral'
        ];
    }

    private function getGraficaResumenData($user, $periodo = '1Y')
    {
        // Obtener el primer registro del usuario para determinar el inicio de datos
        $primeraFecha = collect([
            Paciente::where('user_id', $user->id)->min('created_at'),
            Consulta::where('user_id', $user->id)->min('created_at'),
            Reservaciones::where('user_id', $user->id)->min('created_at')
        ])->filter()->min();

        $fechaInicio = Carbon::now();
        $numeroMeses = 12;

        // Determinar el rango de fechas según el periodo seleccionado
        switch ($periodo) {
            case '1M':

                $fechaInicio = Carbon::now()->startOfMonth();
                $numeroMeses = 1;
                break;
            case '6M':
                $fechaInicio = Carbon::now()->startOfMonth()->subMonths(5);
                $numeroMeses = 6;
                break;
            case '1Y':
                    $fechaInicio = Carbon::now()->startOfYear(); // 1 de Enero del año actual
                    $numeroMeses = 12; // Siempre 12 meses (todo el año)
                    break;
            case 'Todos':
            default:
                if ($primeraFecha) {
                    $fechaInicio = Carbon::parse($primeraFecha)->startOfMonth();
                    $numeroMeses = $fechaInicio->diffInMonths(Carbon::now()) + 1;
                } else {
                    // Si no hay datos, mostrar últimos 12 meses
                    $fechaInicio = Carbon::now()->startOfMonth()->subMonths(11);
                    $numeroMeses = 12;
                }
                break;
        }

        // Obtener datos reales para determinar el rango real de datos
        $pacientesConDatos = Paciente::where('user_id', $user->id)
            ->where('created_at', '>=', $fechaInicio)
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as mes')
            ->groupBy('mes')
            ->pluck('mes');

        $gananciaConDatos = Consulta::where('user_id', $user->id)
            ->where('created_at', '>=', $fechaInicio)
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as mes')
            ->groupBy('mes')
            ->pluck('mes');

        $perdidasConDatos = Reservaciones::where('user_id', $user->id)
            ->where('estado_proximaConsulta', 0)
            ->where('created_at', '>=', $fechaInicio)
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as mes')
            ->groupBy('mes')
            ->pluck('mes');

        // Combinar todos los meses que tienen datos
        $mesesConDatos = collect()
            ->merge($pacientesConDatos)
            ->merge($gananciaConDatos)
            ->merge($perdidasConDatos)
            ->unique()
            ->sort();

        if ($mesesConDatos->isEmpty()) {
            // Si no hay datos, mostrar los últimos 3 meses
            $fechaInicio = Carbon::now()->startOfMonth()->subMonths(2);
            $numeroMeses = 3;
        } else {
            // Ajustar fecha de inicio al primer mes con datos
            $primerMesConDatos = $mesesConDatos->first();
            $fechaInicio = Carbon::createFromFormat('Y-m', $primerMesConDatos)->startOfMonth();

            // Calcular número de meses hasta ahora
            $numeroMeses = $fechaInicio->diffInMonths(Carbon::now()) + 1;

            // Limitar a máximo 24 meses para evitar gráficas muy largas
            if ($numeroMeses > 24) {
                $fechaInicio = Carbon::now()->startOfMonth()->subMonths(23);
                $numeroMeses = 24;
            }
        }

        // Generar array de meses
        $meses = [];
        $resultados = [];

        for ($i = 0; $i < $numeroMeses; $i++) {
            $fecha = (clone $fechaInicio)->addMonths($i);
            $claveMs = $fecha->format('Y-m');
            $nombreMes = $fecha->locale('es')->format('M'); // Ene, Feb, Mar, etc.

            $meses[] = ucfirst($nombreMes);
            $resultados[$claveMs] = [
                'pacientes' => 0,
                'ganancias' => 0,
                'perdidas' => 0
            ];
        }

        // Obtener datos reales
        $pacientesPorMes = Paciente::where('user_id', $user->id)
            ->where('created_at', '>=', $fechaInicio)
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as mes, COUNT(*) as total')
            ->groupBy('mes')
            ->get()
            ->keyBy('mes');

        foreach ($pacientesPorMes as $mes => $data) {
            if (isset($resultados[$mes])) {
                $resultados[$mes]['pacientes'] = $data->total;
            }
        }

        $gananciasPorMes = Consulta::where('user_id', $user->id)
            ->where('created_at', '>=', $fechaInicio)
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as mes, SUM(total_pago) as total')
            ->groupBy('mes')
            ->get()
            ->keyBy('mes');

        foreach ($gananciasPorMes as $mes => $data) {
            if (isset($resultados[$mes])) {
                $resultados[$mes]['ganancias'] = floatval($data->total);
            }
        }

        $perdidasPorMes = Reservaciones::where('user_id', $user->id)
            ->where('estado_proximaConsulta', 0)
            ->where('created_at', '>=', $fechaInicio)
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as mes, SUM(precio_cita) as total')
            ->groupBy('mes')
            ->get()
            ->keyBy('mes');

        foreach ($perdidasPorMes as $mes => $data) {
            if (isset($resultados[$mes])) {
                $resultados[$mes]['perdidas'] = floatval($data->total);
            }
        }

        // Preparar arrays ordenados para la gráfica
        $pacientesData = [];
        $gananciasData = [];
        $perdidasData = [];

        foreach ($resultados as $datos) {
            $pacientesData[] = intval($datos['pacientes']);
            $gananciasData[] = floatval($datos['ganancias']);
            $perdidasData[] = floatval($datos['perdidas']);
        }

        return [
            'meses' => $meses,
            'pacientes' => $pacientesData,
            'ganancias' => $gananciasData,
            'perdidas' => $perdidasData,
            'total_pacientes' => array_sum($pacientesData),
            'total_ganancias' => array_sum($gananciasData),
            'total_perdidas' => array_sum($perdidasData)
        ];
    }


    private function getPacientesRecientes($user)
    {
        return Paciente::where('user_id', $user->id)
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($paciente) {
                // Separar enfermedades por comas y crear badges
                $enfermedades = $paciente->enfermedad ? explode(',', $paciente->enfermedad) : [];
                $badges = collect($enfermedades)->map(function ($enfermedad) {
                    return '<span class="badge bg-danger-subtle text-danger">'.trim($enfermedad).'</span>';
                })->implode(' ');

                return [
                    'foto' => $paciente->foto ?? null,
                    'nombre_completo' => $paciente->nombre.' '.$paciente->apellidos,
                    'telefono' => $paciente->telefono,
                    'enfermedad' => $badges,
                    'edad' => Carbon::parse($paciente->fecha_nacimiento)->age,
                    'fecha_creacion' => Carbon::parse($paciente->created_at)->format('d M Y'),
                    'genero' => $paciente->genero ?? 'No especificado'
                ];
            });
    }

    private function getPacientesSubsecuentes($user)
    {
        // 1. Obtener IDs únicos de pacientes con al menos una reservación de seguimiento (limitado a 5)
        $pacientesIds = Reservaciones::where('user_id', $user->id)
            ->where('motivo_consulta', 'like', '%Seguimiento%')
            ->select('Paciente_ID')
            ->groupBy('Paciente_ID')
            ->take(5) // Solo tomar los primeros 5
            ->pluck('Paciente_ID');

        if ($pacientesIds->isEmpty()) {
            return [
                'data' => []
            ];
        }

        // 2. Obtener datos completos de los pacientes
        $pacientesData = collect();

        foreach ($pacientesIds as $pacienteId) {
            // Obtener la última reservación de seguimiento
            $reservacionSubsecuente = Reservaciones::where('user_id', $user->id)
                ->where('Paciente_ID', $pacienteId)
                ->where('motivo_consulta', 'like', '%Seguimiento%')
                ->orderBy('created_at', 'desc')
                ->first();

            if (!$reservacionSubsecuente) {
                continue;
            }

            // Obtener datos del paciente
            $paciente = Paciente::find($pacienteId);

            // Calcular estadísticas (optimizado con una sola consulta)
            $stats = Reservaciones::where('user_id', $user->id)
                ->where('Paciente_ID', $pacienteId)
                ->selectRaw('count(*) as total_reservaciones')
                ->selectRaw('sum(case when estado_proximaConsulta = 4 then 1 else 0 end) as reservaciones_asistidas')
                ->selectRaw('sum(case when motivo_consulta like "%Seguimiento%" then 1 else 0 end) as total_seguimientos')
                ->first();

            $porcentajeAsistencia = $stats->total_reservaciones > 0
                ? round(($stats->reservaciones_asistidas / $stats->total_reservaciones) * 100)
                : 0;

            $pacientesData->push([
                'foto' => $paciente->foto ?? null,
                'nombre_completo' => trim($reservacionSubsecuente->nombre_paciente . ' ' . $reservacionSubsecuente->apellidos),
                'telefono' => $reservacionSubsecuente->telefono,
                'edad' => $reservacionSubsecuente->edad,
                'fecha_creacion' => $paciente ? $paciente->created_at->format('d M Y') : 'N/A',
                'precio_cita' => $reservacionSubsecuente->precio_cita,
                'porcentaje_asistencia' => $porcentajeAsistencia,
                'total_citas' => $stats->total_reservaciones,
                'citas_seguimiento' => $stats->total_seguimientos
            ]);
        }

        return [
            'data' => $pacientesData->toArray()
        ];
    }

    private function getPorcentajePorEdad($user)
    {
        // Obtener todos los pacientes activos del usuario
        $pacientes = Paciente::where('user_id', $user->id)
            ->where('status', 1)
            ->get();

        if ($pacientes->isEmpty()) {
            return [
                'labels' => [],
                'series' => [],
                'total' => 0
            ];
        }

        // Calcular edades y contar por edad exacta
        $edades = [];

        foreach ($pacientes as $paciente) {
            $edad = Carbon::parse($paciente->fecha_nacimiento)->age;
            if (!isset($edades[$edad])) {
                $edades[$edad] = 0;
            }
            $edades[$edad]++;
        }

        // Ordenar por edad (ascendente)
        ksort($edades);

        // Preparar datos para la gráfica
        $labels = [];
        $series = [];
        $totalPacientes = $pacientes->count();

        foreach ($edades as $edad => $cantidad) {
            $labels[] = "$edad años";
            $series[] = round(($cantidad / $totalPacientes) * 100, 2);
        }

        return [
            'labels' => $labels,
            'series' => $series,
            'total' => $totalPacientes,
            'edades' => $edades // Datos adicionales por si se necesitan
        ];
    }


    private function getPorcentajePorEnfermedad($user)
    {
        // Obtener todos los pacientes activos del usuario
        $pacientes = Paciente::where('user_id', $user->id)
            ->where('status', 1)
            ->get();

        if ($pacientes->isEmpty()) {
            return [
                'labels' => [],
                'series' => [],
                'total' => 0
            ];
        }

        // Contar enfermedades
        $enfermedadesCount = [];

        foreach ($pacientes as $paciente) {
            if (!empty($paciente->enfermedad)) {
                // Separar enfermedades por comas y limpiar espacios
                $enfermedades = array_map('trim', explode(',', $paciente->enfermedad));

                foreach ($enfermedades as $enfermedad) {
                    if (!empty($enfermedad)) {
                        if (!isset($enfermedadesCount[$enfermedad])) {
                            $enfermedadesCount[$enfermedad] = 0;
                        }
                        $enfermedadesCount[$enfermedad]++;
                    }
                }
            }
        }

        // Ordenar por frecuencia (de mayor a menor)
        arsort($enfermedadesCount);

        // Tomar solo las 5 enfermedades más comunes (o menos si hay menos de 5)
        $topEnfermedades = array_slice($enfermedadesCount, 0, 5, true);

        // Calcular porcentajes
        $totalPacientes = $pacientes->count();
        $labels = [];
        $series = [];
        $otherCount = 0;

        foreach ($topEnfermedades as $enfermedad => $count) {
            $labels[] = $enfermedad;
            $series[] = round(($count / $totalPacientes) * 100, 2);
        }

        // Si hay más enfermedades que no caben en el top 5, agrupar como "Otras"
        if (count($enfermedadesCount) > 5) {
            $otherCount = array_sum(array_slice($enfermedadesCount, 5));
            $labels[] = 'Otras';
            $series[] = round(($otherCount / $totalPacientes) * 100, 2);
        }

        return [
            'labels' => $labels,
            'series' => $series,
            'total' => $totalPacientes
        ];
    }

    private function getConsultasRecientes($user)
    {
        // Obtener las 5 consultas más recientes con relaciones
        $consultas = Consulta::with(['paciente', 'tipoConsulta'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return $consultas->map(function ($consulta) {
            return [
                'foto' => $consulta->paciente->foto ?? null,
                'nombre_paciente' => $consulta->nombre_paciente,
                'apellidos' => $consulta->apellidos,
                'nombre_consultorio' => $consulta->nombre_consultorio,
                'total_pago' => $consulta->total_pago,
                'nombre_nutriologo' => $consulta->nombre_nutriologo,
                'tipo_consulta' => $consulta->tipoConsulta->Nombre ?? 'No especificado',
                'fecha_consulta' => Carbon::parse($consulta->created_at)->format('d M Y')
            ];
        });
    }


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
}
