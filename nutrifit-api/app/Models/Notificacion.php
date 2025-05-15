<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    use HasFactory;

    protected $table = 'notificaciones';

    protected $fillable = [
        'Notificacion_ID',
        'Reservacion_ID',
        'Chat_ID',
        'Paciente_ID',
        'user_id',
        'Consulta_ID',

        'tipo_notificacion', // 1: Cita, 2: Mensaje, 3: Recordatorio, 4: Actualizacion Juego Nutrifit
        'nombre',
        'apellidos',
        'foto',
        'descripcion_mensaje',
        'nombre_consultorio',
        'direccion_consultorio',
        'nombre_nutriologo',
        'status', // 0: No leido, 1: Leido
        'estado', // 0: Eliminado 1: Activo
        'tiempo_transcurrido', // Tiempo transcurrido desde la notificacion
        'fecha_creacion',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $primaryKey = 'Notificacion_ID';

    // Casts para los tipos de datos
    protected $casts = [
        'tipo_notificacion' => 'integer',
        'status' => 'integer',
        'estado' => 'integer',
        'fecha_creacion' => 'datetime',
    ];

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

    // Relación con el modelo Consulta
    public function consulta()
    {
        return $this->belongsTo(Consulta::class, 'Consulta_ID');
    }

    // Relación modificada con el modelo Reservaciones (muchas notificaciones pueden pertenecer a una reservación)
    public function reservacion()
    {
        return $this->belongsTo(Reservaciones::class, 'Reservacion_ID', 'Reservacion_ID');
    }

    // Nueva relación con el modelo Chat
    public function chat()
    {
        return $this->belongsTo(Chat::class, 'Chat_ID');
    }

    // Scope para notificaciones visibles en web (estado_proximaConsulta = 4)
    public function scopeVisiblesEnWeb($query)
    {
        return $query->whereHas('reservacion', function($q) {
            $q->where('estado_proximaConsulta', 4);
        });
    }

    // Scope para notificaciones activas
    public function scopeActivas($query)
    {
        return $query->where('estado', 1);
    }

    // Scope para notificaciones no leídas
    public function scopeNoLeidas($query)
    {
        return $query->where('status', 0);
    }

    // Scope para filtrar por tipo de notificación
    public function scopeTipo($query, $tipo)
    {
        return $query->where('tipo_notificacion', $tipo);
    }

    // Scope para notificaciones de chat
    public function scopeChat($query)
    {
        return $query->where('tipo_notificacion', 2)->whereNotNull('Chat_ID');
    }

    // Marcar como leída
    public function marcarComoLeida()
    {
        $this->status = 1;
        $this->save();
        return $this;
    }

    // Método para calcular automáticamente el tiempo transcurrido
    public function actualizarTiempoTranscurrido()
    {
        $this->tiempo_transcurrido = $this->fecha_creacion->diffForHumans();
        $this->save();
        return $this;
    }

    // Crear notificación de mensaje de chat
    /*public static function crearNotificacionChat($chatId, $pacienteId, $userId, $mensaje, $nombreRemitente, $apellidosRemitente, $foto = null)
    {
        return self::create([
            'Chat_ID' => $chatId,
            'Paciente_ID' => $pacienteId,
            'user_id' => $userId,
            'tipo_notificacion' => 2, // 2: Mensaje
            'nombre' => $nombreRemitente,
            'apellidos' => $apellidosRemitente,
            'foto' => $foto,
            'descripcion_mensaje' => $mensaje,
            'status' => 0, // No leído
            'estado' => 1, // Activo
            'fecha_creacion' => now(),
        ]);
    }*/

    // Método para eliminar lógicamente una notificación
    public function eliminar()
    {
        $this->estado = 0;
        $this->save();
        return $this;
    }

    // Boot para establecer valores por defecto y calcular campos automáticos
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($notificacion) {
            // Asegurar que la fecha de creación está establecida
            if (!$notificacion->fecha_creacion) {
                $notificacion->fecha_creacion = now();
            }

            // Calcular tiempo transcurrido al crear
            $notificacion->tiempo_transcurrido = now()->diffForHumans();
        });

        static::created(function ($notificacion) {
            // Lógica adicional después de crear la notificación si es necesario

            // Si es una notificación de tipo chat, podríamos enviar push notification aquí
            if ($notificacion->tipo_notificacion == 2) {
                // Implementar lógica para push notification si se requiere
            }
        });
    }
}
