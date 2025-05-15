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
        Schema::create('ajustes', function (Blueprint $table) {
            $table->increments('Ajuste_ID');
            $table->foreignId('user_id')->constrained('users'); // ← Clave foránea a users.id
            $table->foreignId('rol_id')->constrained('rol');

            // Datos personales
            $table->string('nombre_nutriologo');
            $table->string('apellido_nutriologo');
            $table->string('email')->unique();
            $table->string('telefono', 20)->nullable();
            $table->unsignedTinyInteger('edad')->nullable();
            $table->string('genero', 50)->nullable();
            $table->date('fecha_nacimiento')->nullable();

            // Datos profesionales
            $table->string('profesion')->nullable();
            $table->string('especialidad')->nullable();
            $table->string('universidad')->nullable();
            $table->text('displomados')->nullable();
            $table->string('especializacion')->nullable();
            $table->text('descripcion_especialziacion')->nullable();
            $table->text('experiencia')->nullable();
            $table->text('enfermedades_tratadas')->nullable();

            // Datos de perfil
            $table->string('foto')->nullable();
            $table->string('foto_portada')->nullable();
            $table->unsignedInteger('pacientes_tratados')->default(0);
            $table->string('horario_antencion')->nullable();
            $table->text('descripcion_nutriologo')->nullable();

            // Ubicación
            $table->string('ciudad')->nullable();
            $table->string('estado')->nullable();

            // Datos de sistema
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamps();

            $table->index('user_id');
            $table->index('rol_id');
            $table->index(['nombre_nutriologo', 'apellido_nutriologo']);
            $table->index('especialidad');
            $table->index(['ciudad', 'estado']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ajustes');
    }
};
