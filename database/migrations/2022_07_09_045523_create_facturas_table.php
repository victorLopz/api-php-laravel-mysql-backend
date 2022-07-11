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
        Schema::create('Facturas', function (Blueprint $table) {
            $table->increments('id');

            $table->float('iva');
            $table->float('sub_total');
            $table->float('total');
            $table->float('monto_pagado');
            $table->float('cambio');
            $table->float('suma_abonos');

            $table->unsignedInteger('tipo_almacen_id');
            $table->foreign('tipo_almacen_id')->references('id')->on('Tipos_Almacenes');

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('Usuarios');

            $table->unsignedInteger('tipo_factura');
            $table->foreign('tipo_factura')->references('id')->on('Tipo_Facturas');

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
        Schema::dropIfExists('Facturas');
    }
};
