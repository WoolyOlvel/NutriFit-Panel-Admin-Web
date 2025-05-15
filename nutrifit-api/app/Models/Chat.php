<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $table = 'chat';
    protected $fillable = [
        "Chat_ID",
        "Paciente_ID",
        "user_id",
        'Ultima_Notificacion_ID',

        "nombre_paciente",
        "apellidos",
        "foto",
        'nombre_nutriologo',

        'message',
        'time',
        'read',
        'isOnline',
        'isCurrentUser',
        'fecha_creacion',
        "origen", // 'movil' o 'web' para identificar desde dónde se creó

    ];

        protected $casts = [
        'foto' => 'string',
        'fecha_consulta' => 'datetime',
        'Notificacion_ID' => 'integer',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $primaryKey = 'Chat_ID';


    // Relación con el modelo Paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'Paciente_ID');
    }

    // Relación con el modelo User (nutriólogo)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación con el modelo Notificacion (modificada para relación uno a muchos)
    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class, 'Chat_ID', 'Chat_ID');
    }

    // Método para obtener la última notificación asociada (util para compatibilidad)
    public function ultimaNotificacion()
    {
        return $this->hasOne(Notificacion::class, 'Chat_ID', 'Chat_ID')
            ->latest('fecha_creacion');
    }

    // Obtener nombre completo del nutriólogo
    public function getNombreNutriologoAttribute()
    {
        return $this->user ? $this->user->nombre . ' ' . $this->user->apellidos : null;
    }

    // Método para crear notificaciones de chat sin duplicados
    public function crearNotificacionChat($mensaje, $origen = 'movil')
    {
        // Validar origen
        $origen = in_array($origen, ['movil', 'web']) ? $origen : 'movil';

        // Crear descripción según origen
        if ($origen === 'movil') {
            $descripcion = $this->nombre_paciente . ' ' . $this->apellidos . ' te ha enviado un nuevo mensaje';
        } else {
            $descripcion = 'Nut. ' . $this->nombre_nutriologo . ' te ha enviado un nuevo mensaje';
        }

        // Verificar si ya existe una notificación no leída para este chat con el mismo mensaje
        $notificacionExistente = $this->notificaciones()
            ->where('descripcion_mensaje', $descripcion)
            ->where('status', 0) // No leída
            ->first();

        if ($notificacionExistente) {
            // Si existe, actualizar la fecha y devolver la existente
            $notificacionExistente->update([
                'fecha_creacion' => now(),
                'tiempo_transcurrido' => now()->diffForHumans()
            ]);
            return $notificacionExistente;
        }

        // Crear nueva notificación
        $notificacion = Notificacion::create([
            'Chat_ID' => $this->Chat_ID,
            'Paciente_ID' => $this->Paciente_ID,
            'user_id' => $this->user_id,
            'tipo_notificacion' => 2, // 2: Mensaje de chat
            'nombre' => $this->nombre_paciente,
            'apellidos' => $this->apellidos,
            'foto' => $this->foto,
            'descripcion_mensaje' => $descripcion,
            'status' => 0, // No leído
            'estado' => 1, // Activo
            'fecha_creacion' => now(),
            'tiempo_transcurrido' => now()->diffForHumans(),
            'origen' => $origen,
        ]);

         $notificacion->save();
         $this->update(['Ultima_Notificacion_ID' => $notificacion->Notificacion_ID]);
            $this->save();
        return $notificacion;
    }

    // Método para marcar todas las notificaciones del chat como leídas
    public function marcarNotificacionesComoLeidas()
    {
        return $this->notificaciones()
            ->where('status', 0)
            ->update(['status' => 1]);
    }


}
