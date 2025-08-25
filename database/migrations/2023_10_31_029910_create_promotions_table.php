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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idUsr')->constrained('users');
            $table->integer('include');
            $table->foreignId('idDiscount')->nullable()->constrained('discounts');
            $table->foreignId('id_type')->constrained('listapromociones');
            $table->date('paymentDay');
            $table->string('name');
            $table->string('method');
            $table->string('email');
            $table->date('startday');
            $table->boolean('active');
            $table->date('endDay');
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
        Schema::dropIfExists('promotions');
    }
};
