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
        Schema::create('Almacen', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo1');
            $table->string('codigo2');
            $table->string('nombre_articulo');
            $table->string('modelo');
            $table->string('marca');
            $table->integer('precio_venta');
            $table->integer('precio_compra');
            $table->integer('precio_ruta_uno');
            $table->integer('precio_ruta_dos');
            $table->string('notas');
            $table->boolean('is_visible');
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
        Schema::dropIfExists('Almacen');
    }
};
