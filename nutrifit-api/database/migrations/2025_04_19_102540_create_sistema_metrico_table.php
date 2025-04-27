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
        Schema::create('sistema_metrico', function (Blueprint $table) {
            $table->increments('SistemaMetrico_ID'); // 'SistemaMetrico_ID' será la clave primaria autoincremental
            $table->string('nombre');
            $table->date('fecha_creacion')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sistema_metrico');
    }
};
