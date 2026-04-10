<?php
// 18-5-23 creación de migración
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
        Schema::create('eventos_alternos', function (Blueprint $table) {
            $table->id();
            $table->string('natacion', 6)->nullable();
            $table->string('caminata', 6)->nullable();
            $table->string('ciclismo', 6)->nullable();
            $table->string('barra', 3)->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('id_principal'); // id traido de trabla eventos_principals
            $table->foreign('id_principal')->references('id')->on('eventos_principals');
            $table->unsignedBigInteger('id_evaluado'); // id traido de trabla evaluado
            $table->foreign('id_evaluado')->references('id')->on('evaluados');
            $table->foreignId('user_id'); //FK a user_id
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos_alternos');
    }
};
