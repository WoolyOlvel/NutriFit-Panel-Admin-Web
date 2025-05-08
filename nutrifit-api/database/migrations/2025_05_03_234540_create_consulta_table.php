<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('consulta', function (Blueprint $table) {
            $table->increments('Consulta_ID'); // ID de la consulta

            // Relación con otras tablas
            $table->unsignedInteger('Paciente_ID');
            $table->foreign('Paciente_ID')->references('Paciente_ID')->on('paciente'); // Referencia a la tabla paciente

            $table->unsignedInteger('Tipo_Consulta_ID');
            $table->foreign('Tipo_Consulta_ID')->references('Tipo_Consulta_ID')->on('tipo_consulta'); // Referencia a tipo_consulta

            $table->foreignId('user_id')->constrained('users'); // ← Clave foránea a users.id

            $table->unsignedInteger('Documento_ID');
            $table->foreign('Documento_ID')->references('Documento_ID')->on('documento'); // Referencia a documento

            $table->unsignedInteger('Pago_ID');
            $table->foreign('Pago_ID')->references('Pago_ID')->on('pago'); // Referencia a pago

            $table->unsignedInteger('Divisa_ID');
            $table->foreign('Divisa_ID')->references('Divisa_ID')->on('divisas'); // Referencia a divisa

            // Otros campos
            $table->string('nombre_paciente');
            $table->string('apellidos');
            $table->string('email');
            $table->string('telefono');
            $table->string('genero');
            $table->string('usuario');
            $table->string('enfermedad')->nullable();
            $table->string('localidad')->nullable();
            $table->string('ciudad')->nullable();
            $table->integer('edad')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('nombre_nutriologo');

            // Datos adicionales de consulta
            $table->decimal('peso', 5, 2)->nullable();
            $table->string('talla')->nullable();
            $table->decimal('cintura', 5, 2)->nullable();
            $table->decimal('cadera', 5, 2)->nullable();
            $table->decimal('gc', 5, 2)->nullable();
            $table->decimal('em', 5, 2)->nullable();
            $table->decimal('altura', 5, 2)->nullable();

            // Campos de diagnóstico y evaluación
            $table->text('detalles_diagnostico')->nullable();
            $table->text('resultados_evaluacion')->nullable();
            $table->text('analisis_nutricional')->nullable();
            $table->text('objetivo_descripcion')->nullable();

            // Otros campos
            $table->dateTime('proxima_consulta')->nullable(); // Fecha y hora de la próxima consulta
            $table->text('plan_nutricional_path')->nullable(); // Ruta al archivo del plan nutricional
            $table->decimal('total_pago', 8, 2)->nullable(); // Total a pagar
            $table->date('fecha_creacion')->nullable(); // Fecha de creación
            $table->boolean('estado')->default(true); // Estado de la consulta (activo/inactivo)

            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consulta');
    }
};
