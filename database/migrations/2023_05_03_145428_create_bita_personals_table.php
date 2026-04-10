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
        Schema::create('bita_personals', function (Blueprint $table) {
            $table->id();
            $table->string('dni', 15);
            $table->string('nombre',100);
            $table->string('campo_modificado', 100);
            $table->string('valor_nuevo',50);
            $table->string('valor_viejo',50);
            $table->dateTime('fecha');
            $table->string('accion',100);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bita_personals');
    }
};
