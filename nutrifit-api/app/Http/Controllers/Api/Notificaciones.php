<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservaciones;
use App\Models\User;
use App\Models\Notificacion;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Notificaciones extends Controller
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

    // Obtener notificaciones para el usuario actual
    public function obtenerNotificaciones(Request $request)
    {
        $user = $this->getUserFromToken($request);

        if (!$user) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        // Notificaciones de reservaciones (tipo 1)
        $notificacionesReservaciones = Notificacion::with('reservacion')
            ->where('user_id', $user->id)
            ->where('tipo_notificacion', 1)
            ->whereHas('reservacion', function($query) {
                $query->where('estado_proximaConsulta', 4)
                      ->where('origen', 'movil');
            })
            ->activas()
            ->noLeidas()
            ->orderBy('fecha_creacion', 'desc')
            ->get();

        // Notificaciones de chat (tipo 2) - si las necesitas
        $notificacionesChat = Notificacion::where('user_id', $user->id)
            ->where('tipo_notificacion', 2)
            ->activas()
            ->noLeidas()
            ->orderBy('fecha_creacion', 'desc')
            ->get();

        return response()->json([
            'reservaciones' => $notificacionesReservaciones,
            'mensajes' => $notificacionesChat,
            'total' => $notificacionesReservaciones->count() + $notificacionesChat->count()
        ]);
    }

    // Marcar notificación como leída
    public function marcarLeida(Request $request, $id)
    {
        $user = $this->getUserFromToken($request);

        if (!$user) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        $notificacion = Notificacion::where('Notificacion_ID', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $notificacion->marcarComoLeida();

        return response()->json(['success' => true]);
    }

    // Obtener conteo de notificaciones no leídas
    public function contarNotificaciones(Request $request)
    {
        $user = $this->getUserFromToken($request);

        if (!$user) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        $countReservaciones = Notificacion::where('user_id', $user->id)
            ->where('tipo_notificacion', 1)
            ->whereHas('reservacion', function($query) {
                $query->where('estado_proximaConsulta', 4)
                      ->where('origen', 'movil');
            })
            ->activas()
            ->noLeidas()
            ->count();

        $countChat = Notificacion::where('user_id', $user->id)
            ->where('tipo_notificacion', 2)
            ->activas()
            ->noLeidas()
            ->count();

        return response()->json([
            'total' => $countReservaciones + $countChat,
            'reservaciones' => $countReservaciones,
            'mensajes' => $countChat
        ]);
    }

}
