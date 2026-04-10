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
    public function up() //estructura y creacion de la tabla de registros personales para el personal policial
    {
        Schema::create('evaluados', function (Blueprint $table) {
            $table->id();
            $table->string('dni', 13)->unique();
            $table->string('nombre', 30);
            $table->string('apellido', 30);
            $table->string('sexo', 3);
            $table->date('fechanac', 30);
            $table->string('email', 100)->nullable();
            $table->string('telefono', 12)->nullable();
            $table->string('grado', 30);
            $table->string('categoria', 15);
            $table->string('lugarasig', 100);
            // $table->string('serie', 10)->nullable();
            $table->string('chapa', 10)->nullable();
            $table->string('promocion', 10)->nullable();
            $table->foreignId('user_id'); //FK a user_id
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluados');
    }
};

