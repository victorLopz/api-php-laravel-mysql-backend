<?php

namespace App\Http\Controllers;

use App\Models\Historial_Abono;
use App\Models\Vista_Deudas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistorialAbonoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function vistaDedudas()
    {
        //
        return response()->json([
            "deudas" => Vista_Deudas::get()
        ]);
    }

    public function verAbonos(Request $request, $facturaId)
    {
        //

        $historialAbono = Historial_Abono::where("factura_id", $facturaId)->get();

        return response()->json([
            "hisotialAbonos" => $historialAbono
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $historialAbono = new Historial_Abono();
        $historialAbono->factura_id = $request->facturaId;
        $historialAbono->metodo_pago = $request->metodoPago;
        $historialAbono->concepto = $request->concepto;
        $historialAbono->monto_abonado = $request->montoAbonado;
        $historialAbono->save();

        return response()->json([
            "abonoInsertado" => $historialAbono
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Historial_Abono  $historial_Abono
     * @return \Illuminate\Http\Response
     */
    public function show(Historial_Abono $historial_Abono)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Historial_Abono  $historial_Abono
     * @return \Illuminate\Http\Response
     */
    public function edit(Historial_Abono $historial_Abono)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Historial_Abono  $historial_Abono
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Historial_Abono $historial_Abono)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Historial_Abono  $historial_Abono
     * @return \Illuminate\Http\Response
     */
    public function destroy(Historial_Abono $historial_Abono)
    {
        //
    }
}
