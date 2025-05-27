<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservaciones extends Model
{
    use HasFactory;

    protected $table = 'reservaciones';

    protected $fillable = [
        "Reservacion_ID",
        "Consulta_ID",
        "Paciente_ID",
        "user_id",
        'Ultima_Notificacion_ID',

        // Datos del paciente (unificados para móvil/web)
        "nombre_paciente",
        "apellidos",
        "telefono",
        "genero",
        "usuario",
        "edad",

        // Datos de la reservación/consulta
        "precio_cita",
        "motivo_consulta",
        'nombre_consultorio',
        'direccion_consultorio',
        'nombre_nutriologo',
        "fecha_consulta",
        "fecha_proximaConsulta",
        "estado_proximaConsulta", // 0, 1, 2, 3, 4 (solo 4 visible en web)
        "origen", // 'movil' o 'web' para identificar desde dónde se creó
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $primaryKey = 'Reservacion_ID';

    // Establecer campos que pueden ser null
    protected $casts = [
        'telefono' => 'string',
        'genero' => 'string',
        'usuario' => 'string',
        'edad' => 'integer',
        'precio_cita' => 'decimal:2',
        'motivo_consulta' => 'string',
        'fecha_consulta' => 'datetime',
        'fecha_proximaConsulta' => 'datetime',
        'estado_proximaConsulta' => 'integer',
        'Notificacion_ID' => 'integer',
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

    // Relación con el modelo Notificacion (modificada para relación uno a muchos)
    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class, 'Reservacion_ID', 'Reservacion_ID');
    }

    // Método para obtener la última notificación asociada (util para compatibilidad)
    public function ultimaNotificacion()
    {
        return $this->hasOne(Notificacion::class, 'Reservacion_ID', 'Reservacion_ID')
            ->latest('fecha_creacion');
    }

    // Obtener nombre completo del nutriólogo
    public function getNombreNutriologoAttribute()
    {
        return $this->user ? $this->user->nombre . ' ' . $this->user->apellidos : null;
    }

    // Scope para filtrar reservaciones visibles en web (estado 4)
    public function scopeVisiblesEnWeb($query)
    {
        return $query->where('estado_proximaConsulta', 4);
    }

    // Método para crear notificaciones relacionadas
    public  function crearNotificacion($tipo)
    {
        // Mapear los estados a textos descriptivos
        $estados = [
            0 => 'Cancelado',
            1 => 'En progreso',
            2 => 'Próxima consulta',
            3 => 'Realizado',
            4 => 'En espera'
        ];

        $estadoTexto = $estados[$this->estado_proximaConsulta] ?? 'Desconocido';

        // Usar fecha_proximaConsulta si existe, de lo contrario usar fecha_consulta
        $fechaAUsar = $this->fecha_proximaConsulta ?? $this->fecha_consulta;
        $nombre_nutriologo = $this->nombre_nutriologo;
        if (!$fechaAUsar) {
            // Si no hay ninguna fecha disponible, usar texto alternativo
            $textoFecha = "sin fecha definida";
        } else {
            $textoFecha = $fechaAUsar->format('Y-m-d H:i');
        }


        if ($this->estado_proximaConsulta == 0) {
        // Notificación de cancelación (tipo 1: Cita)
        $descripcion = "Lamentamos informarle que su cita programada para el {$textoFecha} con el Nut. {$this->nombre_nutriologo} ha sido cancelada. ";
        $descripcion .= "Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.";

        }elseif($tipo === 'creación') {
            $descripcion = "Nueva cita programada para " . $this->nombre_consultorio . " " . $this->direccion_consultorio . " el día " . $textoFecha . " con el Nut. " . $nombre_nutriologo . " (Estado: " . $estadoTexto . ")";
        } else {
            $descripcion = "Tu cita ha sido actualizada en " . $this->nombre_consultorio . " " . $this->direccion_consultorio . " con Nut. " . $nombre_nutriologo . " con estado: " . $estadoTexto;

            // Solo agregar la fecha si está disponible
            if ($fechaAUsar) {
                $descripcion .= " para el día " . $textoFecha;
            }
        }

        $notificacion = Notificacion::create([
            'Reservacion_ID' => $this->Reservacion_ID,
            'Paciente_ID' => $this->Paciente_ID,
            'user_id' => $this->user_id,
            'Consulta_ID' => $this->Consulta_ID,
            'tipo_notificacion' => 1,
            'nombre' => $this->nombre_paciente,
            'apellidos' => $this->apellidos,
            'descripcion_mensaje' => $descripcion,
            'nombre_consultorio' => $this->nombre_consultorio,
            'direccion_consultorio' => $this->direccion_consultorio,
            'nombre_nutriologo' => $this->nombre_nutriologo,
            'status' => 0,
            'estado' => 1,
            'fecha_creacion' => now(),
            'origen' => $origen = 'web', // Cambiar a 'movil' si es necesario
        ]);
         $notificacion->save();
         $this->update(['Ultima_Notificacion_ID' => $notificacion->Notificacion_ID]);
            $this->save();
        return $notificacion;
    }
}
