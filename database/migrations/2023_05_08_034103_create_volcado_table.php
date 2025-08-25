<?php

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
    public function up()
    {
        Schema::create('volcado', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('numero_vista');
            $table->unsignedBigInteger('elemento');
            $table->unsignedBigInteger('id_elemento');
            $table->unsignedBigInteger('cities_id');
            $table->foreign('cities_id')->references('id')->on('cities')->onDelete('cascade');
            
            $table->date('fecha_metrica'); // Cambiado a date
            $table->time('hora'); // Nuevo campo para la hora
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
        Schema::dropIfExists('volcado');
    }
};
