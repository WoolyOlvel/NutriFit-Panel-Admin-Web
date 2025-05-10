<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservaciones', function (Blueprint $table) {
            $table->increments('Reservacion_ID');
            $table->unsignedInteger('Consulta_ID')->nullable();
            $table->unsignedInteger('Paciente_ID')->nullable();
            $table->unsignedInteger('Ultima_Notificacion_ID')->nullable(); // Última notificación relacionada

            // Datos del paciente (unificados para móvil/web)
            $table->string('nombre_paciente');
            $table->string('apellidos');
            $table->string('telefono')->nullable();
            $table->string('genero')->nullable();
            $table->string('usuario')->nullable();
            $table->integer('edad')->nullable();

            // Datos de la reservación/consulta
            $table->decimal('precio_cita', 8, 2)->nullable();
            $table->text('motivo_consulta')->nullable();
            $table->text('nombre_consultorio')->nullable();
            $table->text('direccion_consultorio')->nullable();
            $table->text('nombre_nutriologo')->nullable();
            $table->dateTime('fecha_consulta');
            $table->dateTime('fecha_proximaConsulta')->nullable();
            $table->tinyInteger('estado_proximaConsulta')->default(0); // 0, 1, 2, 3, 4 (solo 4 visible en web)
            $table->enum('origen', ['movil', 'web'])->default('web'); // 'movil' o 'web' para identificar desde dónde se creó

            // Timestamps
            $table->timestamps();

            // Claves foráneas
            $table->foreign('Consulta_ID')->references('Consulta_ID')->on('consulta');
            $table->foreign('Paciente_ID')->references('Paciente_ID')->on('paciente');
            $table->foreignId('user_id')->constrained('users'); // ← Clave foránea a users.id

            // Nota: No se agrega clave foránea a Notificacion_ID aquí para evitar referencia circular
            // Esta relación se manejará a nivel de aplicación
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservaciones');
    }
};
