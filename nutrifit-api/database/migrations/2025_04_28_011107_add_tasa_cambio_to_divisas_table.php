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
        Schema::table('divisas', function (Blueprint $table) {
            $table ->decimal('tasa_cambio', 10, 4)->nullable()->after('nombre');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('divisas', function (Blueprint $table) {
            $table->dropColumn('tasa_cambio');
        });
    }
};
