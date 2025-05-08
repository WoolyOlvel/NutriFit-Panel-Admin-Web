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
        Schema::table('consulta', function (Blueprint $table) {
            $table->text('nombre_consultorio')->nullable()->after('proxima_consulta');
            $table->text('direccion_consultorio')->nullable()->after('nombre_consultorio');
            $table->tinyInteger('estado_proximaConsulta')->default(2)->after('estado'); //0 = Cancelado, 1 = En Progreso, 2 = ProximaConsulta, 3 = Realizado (terminado)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consulta', function (Blueprint $table) {
            $table->dropColumn('nombre_consultorio');
            $table->dropColumn('direccion_consultorio');
            $table->dropColumn('estado_proximaConsulta');
        });
    }
};
