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
        Schema::create('Historial_Abonos', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('factura_id');
            $table->foreign('factura_id')->references('id')->on('Facturas');

            $table->string('metodo_pago');
            $table->string('concepto');

            $table->float('monto_abonado');

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
        Schema::dropIfExists('Historial_Abonos');
    }
};
