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
        Schema::create('paciente', function (Blueprint $table) {
            $table->increments('Paciente_ID');
            $table->string('foto')->nullable();
            $table->string('nombre');
            $table->string('apellidos');
            $table->string('email')->unique();
            $table->string('telefono')->unique();
            $table->enum('genero', ['Masculino', 'Femenino', 'Otros']);
            $table->string('usuario')->unique();
            $table->foreignId('rol_id')->constrained('rol');
            $table->foreignId('user_id')->nullable()->constrained('users'); // ← Clave foránea a users.id
            $table->string('enfermedad')->nullable();
            $table->boolean('status')->default(true); // 0 = inactivo, 1 = activo
            $table->boolean('estado')->default(true); // activo o inactivo
            $table->date('fecha_creacion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paciente');
    }
};
