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
        Schema::create('Detalles_Facturas', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('unidades');
            $table->float('precio_compra');
            $table->float('precio_venta');

            $table->unsignedInteger('factura_id');
            $table->foreign('factura_id')->references('id')->on('Facturas');

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
        Schema::dropIfExists('Detalles_Facturas');
    }
};
