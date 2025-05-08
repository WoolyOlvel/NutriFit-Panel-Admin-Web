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
        Schema::create('tipo_consulta', function (Blueprint $table) {
            $table->increments('Tipo_Consulta_ID'); // ID del tipo de consulta
            $table->string('Nombre'); // Nombre del tipo de consulta
            $table->decimal('Precio', 8, 2); // Precio del tipo de consulta
            $table->integer('Duracion'); // Duración en minutos
            $table->decimal('total_pago', 8, 2); // Total a pagar por el tipo de consulta
            $table->boolean('Estado')->default(true); // Estado de la consulta (activo/inactivo)
            $table->date('fecha_creacion')->nullable();
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_consulta');
    }
};
