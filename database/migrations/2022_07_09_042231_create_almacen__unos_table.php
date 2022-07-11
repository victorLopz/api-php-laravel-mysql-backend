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
        Schema::create('Almacen_Uno', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stock');
            $table->boolean('is_visible');

            $table->unsignedInteger('almacen_id');
            $table->foreign('almacen_id')->references('id')->on('Almacen');

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
        Schema::dropIfExists('Almacen_Uno');
    }
};
