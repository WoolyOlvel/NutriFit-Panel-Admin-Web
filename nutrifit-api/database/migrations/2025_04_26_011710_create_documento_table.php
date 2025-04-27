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
        Schema::create('documento', function (Blueprint $table) {
            $table->increments('Documento_ID');
            $table->string('nombre');
            $table->string('tipo_documento');
            $table->date('fecha_creacion')->nullable();
            $table->boolean('estado')->default(true); // 0 = inactivo, 1 = activo
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documento');
    }
};
