<?php

namespace App\Http\Controllers;

use App\Models\Facturas;
use App\Models\Almacen;
use Illuminate\Http\Request;
use App\Models\Detalles_Facturas;
use App\Models\Tipo_Facturas;
use Illuminate\Support\Facades\DB;

class FacturasController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //

        $facturas = new Facturas;
        $facturas->iva = $request->iva;
        $facturas->sub_total = $request->sub_total;
        $facturas->total = $request->total;
        $facturas->monto_pagado = $request->monto_pagado;
        $facturas->cambio = ($request->monto_pagado - $request->total);

        $facturas->suma_abonos = $request->tipo_factura == 2 ? 0 :  $request->total;

        $facturas->tipo_almacen_id = 2;
        $facturas->user_id = $request->user_id;
        $facturas->tipo_factura = $request->tipo_factura;
        $facturas->is_visible = true;
        $facturas->save();

        return response()->json([
            "success" => true,
            $facturas
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardarDetalleFactura(Request $request)
    {
        //
        $detalleFactura = new Detalles_Facturas;
        $detalleFactura->factura_id = $request->factura_id;
        $detalleFactura->unidades = $request->unidades;
        $detalleFactura->almacen_id = $request->almacen_id;
        $producto = Almacen::where("id", $request->almacen_id)->first();
        $detalleFactura->precio_compra = $producto->precio_compra;
        $detalleFactura->precio_venta = $producto->precio_venta;
        $detalleFactura->costo_total = $request->unidades * $request->precio_venta;
        $detalleFactura->save();

        return response()->json([
            $detalleFactura
        ]);
    }

    public function historialFactura(Request $request)
    {
        //
        $historial = Facturas::select("Facturas.id", "Usuarios.nombres", "Usuarios.ruc", "Facturas.created_at", "Facturas.total", "Facturas.monto_pagado", "Tipo_Facturas.nombres as tipo")
            ->join('Tipo_Facturas', 'Tipo_Facturas.id', '=', 'Facturas.tipo_factura')
            ->join('Usuarios', 'Usuarios.id', '=', 'Facturas.user_id')->get();

        return response()->json([
            "historial" => $historial
        ]);
    }

    public function verDetallesFacturas($facturaId)
    {
        $detalle = Detalles_Facturas::select("Almacen.nombre_articulo", "Almacen.codigo1", "Detalles_Facturas.unidades", "Detalles_Facturas.precio_venta", "Detalles_Facturas.costo_total")
            ->join("Almacen", "Almacen.id", "=", "Detalles_Facturas.almacen_id")
            ->where("Detalles_Facturas.factura_id", "=", $facturaId)
            ->get();

        return response()->json([
            $detalle
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Facturas  $facturas
     * @return \Illuminate\Http\Response
     */
    public function tickets(Request $request)
    {
        //
        $ultimoId = Facturas::max("id");

        $data = DB::select(DB::raw(
            "
            SELECT fac.id, 
            fac.total, 
            fac.monto_pagado, 
            al.codigo1,
            fac.cambio, 
            det.unidades, 
            al.nombre_articulo, 
            det.costo_total,
            det.precio_compra,
            al.precio_venta,
            al.modelo,
            fac.created_at,
            fac.tipo_factura,
            cata.nombres as cliente,
            cata.ruc as codigoRUCcedula
        FROM Facturas as fac 
        INNER JOIN Detalles_Facturas as det ON det.factura_id = fac.id
        INNER JOIN Almacen as al ON al.id = det.almacen_id
        INNER JOIN Usuarios as cata ON cata.id = fac.user_id
        WHERE fac.id = '$ultimoId'
        "
        ));

        return response()->json([
            "success" => true,
            "data" => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Facturas  $facturas
     * @return \Illuminate\Http\Response
     */
    public function edit(Facturas $facturas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Facturas  $facturas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Facturas $facturas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Facturas  $facturas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Facturas $facturas)
    {
        //
    }
}
