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
        Schema::table('evaluado_terna_evaluadora', function (Blueprint $table) {
            $table->integer('pechada')->nullable()->after('estado');
            $table->integer('abdominal')->nullable()->after('pechada');
            $table->string('carrera', 10)->nullable()->after('abdominal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evaluado_terna_evaluadora', function (Blueprint $table) {
            $table->dropColumn(['pechada', 'abdominal', 'carrera']);
        });
    }
};
