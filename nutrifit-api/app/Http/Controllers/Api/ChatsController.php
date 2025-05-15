<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Chat;
use App\Models\Paciente;
use App\Models\Notificacion;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Events\NewMessage;
use App\Events\MessageRead;

class ChatsController extends Controller
{
    /**
     * Obtiene el usuario a partir del token
     */
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
     * Verificar si el usuario es nutriólogo
     */
    private function isNutriologo($user)
    {
        return $user->rol_id == 1; // 1 = nutriólogo, 2 = paciente
    }

    /**
     * Obtiene todos los chats para un usuario (nutriólogo) o paciente
     */
    public function index(Request $request)
    {
        $user = $this->getUserFromToken($request);
        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        $isNutriologo = $this->isNutriologo($user);

        $query = Chat::query();

        if ($isNutriologo) {
            // Si es nutriólogo, mostrar todos sus chats con pacientes
            $query->where('user_id', $user->id);
        } else {
            // Si es paciente, buscar por Paciente_ID
            $paciente = Paciente::where('user_id', $user->id)->first();
            if (!$paciente) {
                return response()->json(['error' => 'Paciente no encontrado'], 404);
            }
            $query->where('Paciente_ID', $paciente->Paciente_ID);
        }

        $chats = $query->with(['paciente', 'user', 'ultimaNotificacion'])
            ->orderBy('time', 'desc')
            ->get();

        // Añadir información sobre mensajes no leídos
        foreach ($chats as $chat) {
            $unreadCount = $chat->notificaciones()
                ->where('status', 0)
                ->when(!$isNutriologo, function($q) {
                    // Si es paciente, solo contar notificaciones donde el origen es web (nutriólogo)
                    return $q->where('origen', 'web');
                })
                ->when($isNutriologo, function($q) {
                    // Si es nutriólogo, solo contar notificaciones donde el origen es movil (paciente)
                    return $q->where('origen', 'movil');
                })
                ->count();

            $chat->unread_count = $unreadCount;
        }

        return response()->json($chats);
    }

    /**
     * Obtener los mensajes de un chat específico
     */
    public function getMessages(Request $request, $chatId)
    {
        $user = $this->getUserFromToken($request);
        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        $chat = Chat::find($chatId);
        if (!$chat) {
            return response()->json(['error' => 'Chat no encontrado'], 404);
        }

        // Verificar que el usuario tenga acceso a este chat
        if ($this->isNutriologo($user)) {
            if ($chat->user_id != $user->id) {
                return response()->json(['error' => 'No autorizado'], 403);
            }
        } else {
            $paciente = Paciente::where('user_id', $user->id)->first();
            if (!$paciente || $chat->Paciente_ID != $paciente->Paciente_ID) {
                return response()->json(['error' => 'No autorizado'], 403);
            }
        }

        // Obtener los mensajes de este chat desde la tabla notificaciones
        $mensajes = Notificacion::where('Chat_ID', $chatId)
            ->where('tipo_notificacion', 2) // Tipo: mensaje de chat
            ->orderBy('fecha_creacion', 'asc')
            ->get()
            ->map(function ($notificacion) use ($user) {
                // Determinar si el mensaje es del usuario actual
                $isCurrentUser = $notificacion->origen === 'web' ?
                    $this->isNutriologo($user) :
                    !$this->isNutriologo($user);

                return [
                    'id' => $notificacion->Notificacion_ID,
                    'message' => $notificacion->descripcion_mensaje,
                    'time' => $notificacion->fecha_creacion,
                    'timeFormatted' => Carbon::parse($notificacion->fecha_creacion)->format('H:i'),
                    'read' => $notificacion->status == 1,
                    'isOnline' => true, // Se podría implementar la verificación real de estado online
                    'isCurrentUser' => $isCurrentUser,
                    'origen' => $notificacion->origen
                ];
            });

        // Marcar mensajes como leídos si el usuario es el destinatario
        if ($this->isNutriologo($user)) {
            // Marcar como leídos los mensajes enviados desde móvil (paciente)
            $chat->notificaciones()
                ->where('origen', 'movil')
                ->where('status', 0)
                ->update(['status' => 1]);

            // Emitir evento de mensajes leídos
            event(new MessageRead($chat->Paciente_ID, $chat->Chat_ID));
        } else {
            // Marcar como leídos los mensajes enviados desde web (nutriólogo)
            $chat->notificaciones()
                ->where('origen', 'web')
                ->where('status', 0)
                ->update(['status' => 1]);

            // Emitir evento de mensajes leídos
            event(new MessageRead($chat->user_id, $chat->Chat_ID));
        }

        return response()->json([
            'chat' => $chat,
            'messages' => $mensajes
        ]);
    }

    /**
     * Enviar un nuevo mensaje
     */
    public function sendMessage(Request $request)
    {
        $user = $this->getUserFromToken($request);
        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        $validator = Validator::make($request->all(), [
            'chat_id' => 'required|integer|exists:chat,Chat_ID',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $chatId = $request->input('chat_id');
        $mensaje = $request->input('message');

        $chat = Chat::find($chatId);
        if (!$chat) {
            return response()->json(['error' => 'Chat no encontrado'], 404);
        }

        // Verificar que el usuario tenga acceso a este chat
        if ($this->isNutriologo($user)) {
            if ($chat->user_id != $user->id) {
                return response()->json(['error' => 'No autorizado'], 403);
            }
            $origen = 'web';
            $destinatarioId = $chat->Paciente_ID; // ID del paciente
        } else {
            $paciente = Paciente::where('user_id', $user->id)->first();
            if (!$paciente || $chat->Paciente_ID != $paciente->Paciente_ID) {
                return response()->json(['error' => 'No autorizado'], 403);
            }
            $origen = 'movil';
            $destinatarioId = $chat->user_id; // ID del nutriólogo
        }

        // Crear notificación para el mensaje
        try {
            DB::beginTransaction();

            // Actualizar chat con el último mensaje
            $chat->update([
                'message' => $mensaje,
                'time' => now(),
                'read' => false,
                'isCurrentUser' => true,
                'origen' => $origen
            ]);

            // Crear la notificación del mensaje
            $notificacion = new Notificacion([
                'Chat_ID' => $chat->Chat_ID,
                'Paciente_ID' => $chat->Paciente_ID,
                'user_id' => $chat->user_id,
                'tipo_notificacion' => 2, // Tipo: mensaje de chat
                'nombre' => $origen === 'movil' ? $chat->nombre_paciente : $chat->nombre_nutriologo,
                'apellidos' => $origen === 'movil' ? $chat->apellidos : '',
                'foto' => $origen === 'movil' ? $chat->foto : null,
                'descripcion_mensaje' => $mensaje,
                'status' => 0, // No leído
                'estado' => 1, // Activo
                'fecha_creacion' => now(),
                'tiempo_transcurrido' => now()->diffForHumans(),
                'origen' => $origen,
            ]);

            $notificacion->save();

            // Actualizar el ID de la última notificación en el chat
            $chat->update(['Ultima_Notificacion_ID' => $notificacion->Notificacion_ID]);

            DB::commit();

            // Emitir evento para WebSockets
            event(new NewMessage($destinatarioId, [
                'chat' => $chat,
                'message' => [
                    'id' => $notificacion->Notificacion_ID,
                    'message' => $mensaje,
                    'time' => $notificacion->fecha_creacion,
                    'timeFormatted' => Carbon::parse($notificacion->fecha_creacion)->format('H:i'),
                    'read' => false,
                    'isOnline' => true,
                    'isCurrentUser' => false, // Para el destinatario no será el usuario actual
                    'origen' => $origen
                ]
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Mensaje enviado correctamente',
                'notification' => $notificacion
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al enviar mensaje: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error al enviar el mensaje',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear un nuevo chat
     */
    public function createChat(Request $request)
    {
        $user = $this->getUserFromToken($request);
        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        $validator = Validator::make($request->all(), [
            'paciente_id' => 'required|integer|exists:paciente,Paciente_ID',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Solo nutriólogos pueden crear chats
        if (!$this->isNutriologo($user)) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $pacienteId = $request->input('paciente_id');
        $mensaje = $request->input('message');

        $paciente = Paciente::find($pacienteId);
        if (!$paciente) {
            return response()->json(['error' => 'Paciente no encontrado'], 404);
        }

        // Verificar si ya existe un chat entre este nutriólogo y paciente
        $chatExistente = Chat::where('Paciente_ID', $pacienteId)
            ->where('user_id', $user->id)
            ->first();

        if ($chatExistente) {
            // Si ya existe un chat, enviar mensaje en ese chat
            $request->merge(['chat_id' => $chatExistente->Chat_ID]);
            return $this->sendMessage($request);
        }

        // Crear nuevo chat
        try {
            DB::beginTransaction();

            $chat = new Chat([
                'Paciente_ID' => $pacienteId,
                'user_id' => $user->id,
                'nombre_paciente' => $paciente->nombre,
                'apellidos' => $paciente->apellidos,
                'foto' => $paciente->foto,
                'nombre_nutriologo' => $user->nombre . ' ' . $user->apellidos,
                'message' => $mensaje,
                'time' => now(),
                'read' => false,
                'isOnline' => true,
                'isCurrentUser' => true,
                'fecha_creacion' => now(),
                'origen' => 'web'
            ]);

            $chat->save();

            // Crear la notificación del primer mensaje
            $notificacion = new Notificacion([
                'Chat_ID' => $chat->Chat_ID,
                'Paciente_ID' => $pacienteId,
                'user_id' => $user->id,
                'tipo_notificacion' => 2, // Tipo: mensaje de chat
                'nombre' => $user->nombre,
                'apellidos' => $user->apellidos,
                'foto' => null,
                'descripcion_mensaje' => $mensaje,
                'status' => 0, // No leído
                'estado' => 1, // Activo
                'fecha_creacion' => now(),
                'tiempo_transcurrido' => now()->diffForHumans(),
                'origen' => 'web',
            ]);

            $notificacion->save();

            // Actualizar el ID de la última notificación en el chat
            $chat->update(['Ultima_Notificacion_ID' => $notificacion->Notificacion_ID]);

            DB::commit();

            // Emitir evento para WebSockets
            $pacienteUserId = Paciente::where('Paciente_ID', $pacienteId)->value('user_id');
            if ($pacienteUserId) {
                event(new NewMessage($pacienteUserId, [
                    'chat' => $chat,
                    'message' => [
                        'id' => $notificacion->Notificacion_ID,
                        'message' => $mensaje,
                        'time' => $notificacion->fecha_creacion,
                        'timeFormatted' => Carbon::parse($notificacion->fecha_creacion)->format('H:i'),
                        'read' => false,
                        'isOnline' => true,
                        'isCurrentUser' => false,
                        'origen' => 'web'
                    ]
                ]));
            }

            return response()->json([
                'success' => true,
                'message' => 'Chat creado correctamente',
                'chat' => $chat,
                'notification' => $notificacion
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear chat: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error al crear el chat',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Marcar mensajes como leídos
     */
    public function markAsRead(Request $request, $chatId)
    {
        $user = $this->getUserFromToken($request);
        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        $chat = Chat::find($chatId);
        if (!$chat) {
            return response()->json(['error' => 'Chat no encontrado'], 404);
        }

        // Verificar que el usuario tenga acceso a este chat
        if ($this->isNutriologo($user)) {
            if ($chat->user_id != $user->id) {
                return response()->json(['error' => 'No autorizado'], 403);
            }
            // Marcar como leídos los mensajes enviados desde móvil (paciente)
            $chat->notificaciones()
                ->where('origen', 'movil')
                ->where('status', 0)
                ->update(['status' => 1]);

            // Emitir evento de mensajes leídos
            event(new MessageRead($chat->Paciente_ID, $chat->Chat_ID));
        } else {
            $paciente = Paciente::where('user_id', $user->id)->first();
            if (!$paciente || $chat->Paciente_ID != $paciente->Paciente_ID) {
                return response()->json(['error' => 'No autorizado'], 403);
            }
            // Marcar como leídos los mensajes enviados desde web (nutriólogo)
            $chat->notificaciones()
                ->where('origen', 'web')
                ->where('status', 0)
                ->update(['status' => 1]);

            // Emitir evento de mensajes leídos
            event(new MessageRead($chat->user_id, $chat->Chat_ID));
        }

        return response()->json([
            'success' => true,
            'message' => 'Mensajes marcados como leídos'
        ]);
    }

    /**
     * Obtener contador de mensajes no leídos
     */
    public function getUnreadCount(Request $request)
    {
        $user = $this->getUserFromToken($request);
        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        $isNutriologo = $this->isNutriologo($user);

        $query = Chat::query();

        if ($isNutriologo) {
            // Si es nutriólogo, contar en sus chats
            $query->where('user_id', $user->id);
        } else {
            // Si es paciente, buscar por Paciente_ID
            $paciente = Paciente::where('user_id', $user->id)->first();
            if (!$paciente) {
                return response()->json(['error' => 'Paciente no encontrado'], 404);
            }
            $query->where('Paciente_ID', $paciente->Paciente_ID);
        }

        $chats = $query->get();

        $totalUnread = 0;
        foreach ($chats as $chat) {
            $unreadCount = $chat->notificaciones()
                ->where('status', 0)
                ->when(!$isNutriologo, function($q) {
                    // Si es paciente, solo contar notificaciones donde el origen es web (nutriólogo)
                    return $q->where('origen', 'web');
                })
                ->when($isNutriologo, function($q) {
                    // Si es nutriólogo, solo contar notificaciones donde el origen es movil (paciente)
                    return $q->where('origen', 'movil');
                })
                ->count();

            $totalUnread += $unreadCount;
        }

        return response()->json([
            'unread_count' => $totalUnread
        ]);
    }

    /**
     * Buscar chats
     */
    public function searchChats(Request $request)
    {
        $user = $this->getUserFromToken($request);
        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        $query = $request->input('query');
        if (!$query) {
            return $this->index($request);
        }

        $isNutriologo = $this->isNutriologo($user);

        $chatQuery = Chat::query();

        if ($isNutriologo) {
            // Si es nutriólogo, buscar entre sus pacientes
            $chatQuery->where('user_id', $user->id)
                ->where(function($q) use ($query) {
                    $q->where('nombre_paciente', 'like', "%{$query}%")
                      ->orWhere('apellidos', 'like', "%{$query}%");
                });
        } else {
            // Si es paciente, buscar entre sus nutriólogos
            $paciente = Paciente::where('user_id', $user->id)->first();
            if (!$paciente) {
                return response()->json(['error' => 'Paciente no encontrado'], 404);
            }
            $chatQuery->where('Paciente_ID', $paciente->Paciente_ID)
                ->where('nombre_nutriologo', 'like', "%{$query}%");
        }

        $chats = $chatQuery->with(['paciente', 'user', 'ultimaNotificacion'])
            ->orderBy('time', 'desc')
            ->get();

        // Añadir información sobre mensajes no leídos
        foreach ($chats as $chat) {
            $unreadCount = $chat->notificaciones()
                ->where('status', 0)
                ->when(!$isNutriologo, function($q) {
                    // Si es paciente, solo contar notificaciones donde el origen es web (nutriólogo)
                    return $q->where('origen', 'web');
                })
                ->when($isNutriologo, function($q) {
                    // Si es nutriólogo, solo contar notificaciones donde el origen es movil (paciente)
                    return $q->where('origen', 'movil');
                })
                ->count();

            $chat->unread_count = $unreadCount;
        }

        return response()->json($chats);
    }
}
