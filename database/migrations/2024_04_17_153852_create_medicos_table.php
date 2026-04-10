<?php
   // 17-4-23 creación de migración
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()//estructura y creacion de la tabla de registros de evaluacion medica para el personal policial
    {
        Schema::create('medicos', function (Blueprint $table) {
            $table->id();
            $table->string('periodo', 15);
            $table->string('pulso', 3)->nullable();
            $table->string('saturacion', 4)->nullable();
            $table->string('presion', 8);
            $table->decimal('altura', 4, 2);
            $table->decimal('abdomen', 6, 2);
            $table->decimal('cuello', 6, 2);
            $table->decimal('mediabocue', 4, 2);
            $table->decimal('factoabdocue', 4, 2);
            $table->decimal('factoaltu', 4, 2);
            $table->decimal('grasa', 4, 2);
            $table->decimal('musculo', 4, 2)->nullable();
            $table->decimal('libras_masa', 7, 2)->nullable();
            $table->decimal('sobrepeso_masa_grasa', 7, 2)->nullable();
            $table->decimal('grasa_visceral', 4, 2)->nullable();
            $table->integer('pesoreal');
            $table->integer('pesoideal');
            $table->decimal('exceso', 4, 2);
            $table->string('condicion', 50);
            $table->string('medico', 50);
            $table->string('lugar', 100);
            $table->string('equipo', 3)->nullable();
            $table->string('grado_policial')->nullable();
            $table->string('observaciones', 255)->nullable();
            $table->string('doc_firma', 250)->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('id_evaluado'); // id traido de trabla evaluado
            $table->foreign('id_evaluado')->references('id')->on('evaluados');
            $table->foreignId('user_id'); //FK a user_id
            $table->foreignId('lugar_id')->constrained('lugares_evaluacion');
        });
    }
   /**
     * Reverse the migrations.
     *
     * @return void
     */

    public function down()
    {
        Schema::dropIfExists('medicos');
    }
};
