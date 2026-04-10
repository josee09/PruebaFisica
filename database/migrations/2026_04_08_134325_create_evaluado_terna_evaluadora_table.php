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
        Schema::create('evaluado_terna_evaluadora', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evaluado_id')->constrained('evaluados')->onDelete('cascade');
            $table->foreignId('terna_evaluadora_id')->constrained('ternas_evaluadoras')->onDelete('cascade');
            $table->string('periodo'); // Ordinario, Extraordinario
            $table->date('fecha_asignacion');
            $table->string('estado', 20)->default('asignado'); // asignado, en_evaluacion, completado
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluado_terna_evaluadora');
    }
};
