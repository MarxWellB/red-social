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
        Schema::table('posts', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('onlinestore_id')->nullable();
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
        Schema::table('posts', function (Blueprint $table) {
            //
            $table->dropForeign('posts_onlinestore_id_foreign');
    $table->dropColumn('onlinestore_id');
        });
    }
};
