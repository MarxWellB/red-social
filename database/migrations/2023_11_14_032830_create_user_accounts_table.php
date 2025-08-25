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
        Schema::create('user_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('onlinestore_id'); // Clave foránea
            $table->string('username');
            $table->string('profile_link')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();

            // Definir la relación
            $table->foreign('onlinestore_id')->references('id')->on('onlinestores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_accounts');
    }
};
