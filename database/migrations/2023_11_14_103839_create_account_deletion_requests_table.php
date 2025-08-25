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
        Schema::create('account_deletion_requests', function (Blueprint $table) {
            $table->id();
            $table->string('email'); // Correo electrónico de quien solicita la eliminación
            $table->unsignedBigInteger('user_account_id'); // Nombre de usuario de la cuenta a eliminar
            $table->text('reason')->nullable(); // Razón opcional de la eliminación
            $table->string('status')->default(0);// Estado de la solicitud (por ejemplo, 'pending', 'approved', 'rejected')
            $table->timestamps();
            $table->foreign('user_account_id')->references('id')->on('users');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_deletion_requests');
    }
};
