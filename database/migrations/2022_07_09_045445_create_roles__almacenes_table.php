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
        Schema::create('Tipos_Almacenes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rol');
            $table->string('nivel');
            $table->string('nombre_almacen');
            $table->boolean('descuento');
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
        Schema::dropIfExists('Tipos_Almacenes');
    }
};
