<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->increments('Notificacion_ID');
            $table->unsignedInteger('Reservacion_ID')->nullable();
            $table->unsignedInteger('Chat_ID')->nullable(); // Preparado para futuro modelo Chat
            $table->unsignedInteger('Paciente_ID')->nullable();
            $table->unsignedInteger('Consulta_ID')->nullable();

            // Datos de la notificación
            $table->tinyInteger('tipo_notificacion'); // 1: Cita, 2: Mensaje, 3: Recordatorio, 4: Actualizacion Juego Nutrifit
            $table->string('nombre')->nullable(); // Nombre de quien genera la notificación
            $table->string('apellidos')->nullable(); // Apellidos de quien genera la notificación
            $table->string('foto')->nullable(); // URL o ruta de la foto del perfil
            $table->text('descripcion_mensaje');
            $table->text('nombre_consultorio')->nullable();
            $table->text('direccion_consultorio')->nullable();
            $table->text('nombre_nutriologo')->nullable();
            $table->tinyInteger('status')->default(0); // 0: No leído, 1: Leído
            $table->tinyInteger('estado')->default(1); // 0: Eliminado, 1: Activo
            $table->string('tiempo_transcurrido')->nullable(); // "30 minutes ago"
            $table->dateTime('fecha_creacion');

            // Timestamps
            $table->timestamps();

            // Claves foráneas
            $table->foreign('Reservacion_ID')->references('Reservacion_ID')->on('reservaciones');
            $table->foreign('Paciente_ID')->references('Paciente_ID')->on('paciente');
            $table->foreignId('user_id')->constrained('users'); // ← Clave foránea a users.id
            $table->foreign('Consulta_ID')->references('Consulta_ID')->on('consulta');

            // No se agrega la clave foránea para Chat_ID aquí ya que aún no existe el modelo
            // Se deberá crear cuando se implemente el modelo Chat

            // Índices para mejorar el rendimiento de las consultas frecuentes
            $table->index(['tipo_notificacion', 'status', 'estado']);
            $table->index('fecha_creacion');
        });

        // Este trigger actualiza el campo Notificacion_ID en reservaciones cuando se crea una notificación
        DB::unprepared('
            CREATE TRIGGER update_reservacion_notificacion_id AFTER INSERT ON notificaciones
            FOR EACH ROW
            BEGIN
                IF NEW.Reservacion_ID IS NOT NULL AND NEW.tipo_notificacion = 1 THEN
                    UPDATE reservaciones
                    SET Ultima_Notificacion_ID = NEW.Notificacion_ID
                    WHERE Reservacion_ID = NEW.Reservacion_ID;
                END IF;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar el trigger primero
        DB::unprepared('DROP TRIGGER IF EXISTS update_reservacion_notificacion_id');

        Schema::dropIfExists('notificaciones');
    }
};
