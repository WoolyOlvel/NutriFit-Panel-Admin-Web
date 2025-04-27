<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('paciente', function (Blueprint $table) {
            $table->string('ciudad')->nullable()->after('estado');
            $table->string('localidad')->nullable()->after('ciudad');
            $table->integer('edad')->nullable()->after('localidad');
            $table->date('fecha_nacimiento')->nullable()->after('edad');
        });
    }

    public function down(): void
    {
        Schema::table('paciente', function (Blueprint $table) {
            $table->dropColumn(['ciudad', 'localidad', 'edad', 'fecha_nacimiento']);
        });
    }
};
