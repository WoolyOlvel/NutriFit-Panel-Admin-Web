<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notificacion;
use App\Models\Paciente;

class NotificacionesMovilController extends Controller
{
    // Obtener notificaciones para el paciente en móvil
    public function obtenerNotificaciones(Request $request, $pacienteId)
    {
        // Verificar que el paciente existe
        $paciente = Paciente::find($pacienteId);
        if (!$paciente) {
            return response()->json(['error' => 'Paciente no encontrado'], 404);
        }

        // Notificaciones de reservaciones (tipo 1) para todos los estados
        $notificaciones = Notificacion::with('reservacion')
            ->where('Paciente_ID', $pacienteId)
            ->where('tipo_notificacion', 1)
            ->where('estado', 1) // Solo activas
            ->where('status_movil', 0) // Solo no leídas
            ->orderBy('fecha_creacion', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'notificaciones' => $notificaciones,
            'total' => $notificaciones->count()
        ]);
    }

    // Marcar notificación como leída
    public function marcarLeida($notificacionId, $pacienteId)
    {
        $notificacion = Notificacion::where('Notificacion_ID', $notificacionId)
            ->where('Paciente_ID', $pacienteId)
            ->first();

        if (!$notificacion) {
            return response()->json(['error' => 'Notificación no encontrada'], 404);
        }

        $notificacion->status_movil = 1; // Marcar como leída
        $notificacion->save();

        return response()->json(['success' => true]);
    }

    // Marcar todas como leídas
    public function marcarTodasLeidas($pacienteId)
    {
        Notificacion::where('Paciente_ID', $pacienteId)
            ->where('tipo_notificacion', 1)
            ->where('estado', 1)
            ->where('status_movil', 0)
            ->update(['status_movil' => 1]);

        return response()->json(['success' => true]);
    }

    // Eliminar notificaciones
    public function eliminarNotificaciones($pacienteId)
    {
        Notificacion::where('Paciente_ID', $pacienteId)
            ->where('tipo_notificacion', 1)
            ->where('estado', 1)
            ->update(['estado_movil' => 0]);

        return response()->json(['success' => true]);
    }

    // Contar notificaciones no leídas
    public function contarNotificaciones($pacienteId)
    {
        $count = Notificacion::where('Paciente_ID', $pacienteId)
            ->where('tipo_notificacion', 1)
            ->where('estado', 1)
            ->where('status_movil',0)
            ->count();

        return response()->json([
            'success' => true,
            'total' => $count
        ]);
    }


}
