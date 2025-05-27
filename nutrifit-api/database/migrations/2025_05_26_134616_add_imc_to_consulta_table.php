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

            $table->decimal('proteina', 5, 2)->nullable()->after('altura');
            $table->decimal('ec', 5, 2)->nullable()->after('proteina');
            $table->decimal('me', 5, 2)->nullable()->after('ec');
            $table->decimal('gv', 5, 2)->nullable()->after('me');
            $table->decimal('pg', 5, 2)->nullable()->after('gv');
            $table->decimal('gs', 5, 2)->nullable()->after('pg');
            $table->decimal('meq', 5, 2)->nullable()->after('gs');
            $table->decimal('bmr', 5, 2)->nullable()->after('meq');
            $table->decimal('ac', 5, 2)->nullable()->after('bmr');
            $table->decimal('imc', 5, 2)->nullable()->after('ac');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consulta', function (Blueprint $table) {
            $table->dropColumn('proteina');
            $table->dropColumn('ec');
            $table->dropColumn('me');
            $table->dropColumn('gv');
            $table->dropColumn('pg');
            $table->dropColumn('gs');
            $table->dropColumn('meq');
            $table->dropColumn('bmr');
            $table->dropColumn('ac');
            $table->dropColumn('imc');
        });
    }
};
