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
        Schema::create('eventos_principals', function (Blueprint $table) {
            $table->id();
            $table->string('pechada', 3)->nullable();
            $table->string('abdominal', 3)->nullable();
            $table->string('carrera', 6)->nullable();    
            $table->timestamps();
            $table->unsignedBigInteger('id_evaluado'); // id traido de trabla evaluado
            $table->foreign('id_evaluado')->references('id')->on('evaluados');
            $table->unsignedBigInteger('id_medico'); // id traido de trabla evaluado
            $table->foreign('id_medico')->references('id')->on('medicos');
            $table->foreignId('user_id'); //FK a user_id
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos_principals');
    }
};
