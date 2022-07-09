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
        Schema::create('Estado_Usuarios', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('estado');

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('Usuarios');

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
        Schema::dropIfExists('Estado_Usuarios');
    }
};
