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
        Schema::create('resultado_pruebas', function (Blueprint $table) {
            $table->id();
            $table->string('evaluacion', 15);
            $table->string('fecha', 4);
            $table->string('periodo', 15);
            $table->string('npechada', 3)->nullable();
            $table->string('nabdominal', 3)->nullable();
            $table->string('ncarrera', 3)->nullable();
            $table->string('nnatacion', 3)->nullable();
            $table->string('ncaminata', 3)->nullable();
            $table->string('nciclismo', 3)->nullable();
            $table->string('nbarra', 3)->nullable();
            $table->string('npromedio', 10);
            $table->string('pesoexc', 10);
            $table->string('npesoexc', 10);
            $table->string('grado1');
            $table->string('grado2');
            $table->string('grado3');
            $table->string('grado4');
            $table->string('grado5');
            $table->string('estado', 10);
            $table->text('obs')->nullable();
            $table->string('oficialjefe', 40);
            $table->string('evaluador1', 40);
            $table->string('evaluador2', 40)->nullable();
            $table->string('evaluador3', 40)->nullable();
            $table->string('evaluador4', 40)->nullable();
            $table->string('doc_obs', 250)->nullable();
            $table->string('doc_firma', 250)->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('id_evaluado'); // id traido de trabla evaluado
            $table->foreign('id_evaluado')->references('id')->on('evaluados');
            $table->unsignedBigInteger('id_principal')->nullable(); // id traido de trabla eventos_principals
            $table->foreign('id_principal')->references('id')->on('eventos_principals');
            $table->unsignedBigInteger('id_alterno')->nullable(); // id traido de trabla eventos_principals
            $table->foreign('id_alterno')->references('id')->on('eventos_alternos');
            $table->foreignId('user_id'); //FK a user_id
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resultado_pruebas');
    }
};
