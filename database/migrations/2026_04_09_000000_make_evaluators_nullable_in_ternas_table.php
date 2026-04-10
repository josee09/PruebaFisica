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
        Schema::table('ternas_evaluadoras', function (Blueprint $table) {
            $table->unsignedBigInteger('E1_id')->nullable()->change();
            $table->unsignedBigInteger('E2_id')->nullable()->change();
            $table->unsignedBigInteger('E3_id')->nullable()->change();
            $table->unsignedBigInteger('E4_id')->nullable()->change();
            $table->unsignedBigInteger('OJEE_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ternas_evaluadoras', function (Blueprint $table) {
            // No revertimos a NOT NULL por si acaso ya hay datos nulos
        });
    }
};
