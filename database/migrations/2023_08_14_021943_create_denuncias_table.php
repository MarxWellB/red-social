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
        Schema::create('denuncias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tipo_elemento');
            $table->unsignedBigInteger('id_elemento_denunciado'); // ID del elemento denunciado (por ejemplo, ID del post)
            $table->string('correo_que_denuncia');
            $table->text('detalles');
            $table->text('motivacion')->nullable();
            $table->unsignedBigInteger('estado');
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
        Schema::dropIfExists('denuncias');
    }
};
