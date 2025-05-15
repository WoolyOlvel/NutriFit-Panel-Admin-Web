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
        Schema::table('ajustes', function (Blueprint $table) {
            $table->string('modalidad')->nullable()->after('estado');
            $table->string('disponibilidad')->nullable()->after('modalidad');
            $table->boolean('status')->default(true)->after('disponibilidad');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ajustes', function (Blueprint $table) {
            $table->dropColumn('modalidad');
            $table->dropColumn('disponibilidad');
            $table->dropColumn('status');

        });
    }
};
