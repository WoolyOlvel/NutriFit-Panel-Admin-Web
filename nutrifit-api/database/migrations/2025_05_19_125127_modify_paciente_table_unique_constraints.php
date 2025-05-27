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
        Schema::table('paciente', function (Blueprint $table) {
            // 1. Eliminar las restricciones unique existentes
            $table->dropUnique(['email']);
            $table->dropUnique(['telefono']);
            $table->dropUnique(['usuario']);

            // 2. Agregar nueva restricción compuesta para email + user_id
            $table->unique(['email', 'user_id']);

            // 3. Mantener unique para telefono y usuario pero con prefijo para duplicados
            $table->unique(['telefono']);
            $table->unique(['usuario']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paciente', function (Blueprint $table) {
            // Para revertir los cambios
            $table->dropUnique(['email', 'user_id']);
            $table->dropUnique(['telefono']);
            $table->dropUnique(['usuario']);

            $table->string('email')->unique()->change();
            $table->string('telefono')->unique()->change();
            $table->string('usuario')->unique()->change();
        });
    }
};
