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
        Schema::create('nutridesafios', function (Blueprint $table) {
            $table->increments('NutriDesafios_ID');
            $table->string('foto')->nullable();
            $table->string('nombre');
            $table->string('url');
            $table->string('tipo');
            $table->tinyInteger ('status')->default(1); // 0 = inactivo, 1 = activo, 2 = Proximamente
            $table->boolean('estado')->default(true); // activo o inactivo
            $table->date('fecha_creacion')->nullable();
            $table->foreignId('user_id')->constrained('users'); // ← Clave foránea a users.id
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nutridesafios');
    }
};
