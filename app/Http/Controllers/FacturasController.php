<?php

namespace App\Http\Controllers;

use App\Models\Facturas;
use App\Models\Almacen;
use App\Models\Almacen_Uno;
use Illuminate\Http\Request;
use App\Models\Detalles_Facturas;
use App\Models\Tipo_Facturas;
use App\Models\Historial_Abono;
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

        date_default_timezone_set("America/Costa_Rica"); // ("America/Santiago") por ejemplo
        $timestamp = time();
        $hoy = getdate($timestamp);

        $fechaHoy = $hoy['year'] . "-" . $hoy['mon'] . "-" . $hoy['mday'];

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
        $facturas->date_insert = $fechaHoy;
        $facturas->save();

        if ($request->tipo_factura == 2) {

            $historialAbono = new Historial_Abono();
            $historialAbono->factura_id = $facturas->id;
            $historialAbono->metodo_pago = "-";
            $historialAbono->concepto = "-";
            $historialAbono->monto_abonado = 0;
            $historialAbono->save();
        }

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
        
        $detalleFactura->precio_compra = $request->precio_compra;
        $detalleFactura->precio_venta = $request->precio_unidad_venta;
        
        $multi = intval($request->unidades) * intval($request->precio_unidad_venta);
        
        $detalleFactura->costo_total = $multi;
        $detalleFactura->save();

        $producto = Almacen_Uno::where("almacen_id", $request->almacen_id)->first();
        $producto->stock = $producto->stock - $request->unidades;
        $producto->save();

        return response()->json([
            $detalleFactura,
        ]);
    }

    public function historialFactura(Request $request)
    {
        //
        $historial = Facturas::select(
            "Facturas.id",
            "Usuarios.nombres",
            "Usuarios.ruc",
            DB::raw('DATE_FORMAT(Facturas.created_at, "%d/%m/%Y") as created_at'),
            "Facturas.total",
            "Facturas.monto_pagado",
            "Tipo_Facturas.nombres as tipo"
        )
            ->join('Tipo_Facturas', 'Tipo_Facturas.id', '=', 'Facturas.tipo_factura')
            ->join('Usuarios', 'Usuarios.id', '=', 'Facturas.user_id')
            ->where("Facturas.is_visible", "=", 1)
            ->orderBy('Facturas.id', 'DESC')->get();

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
            det.precio_venta,
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
    public function destroy(Facturas $facturas, $facturaId)
    {
        //
        $facturas = Facturas::where("id", $facturaId)->first();
        $facturas->is_visible = false;
        $facturas->save();

        $detalleFacturas = Detalles_Facturas::where("factura_id", $facturaId)->get();

        foreach ($detalleFacturas as $key) {
            # code...
            $almacenUno = Almacen_Uno::where([
                ["almacen_id", "=", $key->almacen_id]
            ])->first();

            $almacenUno->stock = $key->unidades + $almacenUno->stock;
            $almacenUno->save();
        }
        return response()->json([
            "success" => true
        ]);
    }

    public function imprimirFactura($facturasId)
    {
        //
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
                    det.precio_venta,
                    al.modelo,
                    fac.created_at,
                    fac.tipo_factura,
                    cata.nombres as cliente,
                    cata.ruc as codigoRUCcedula
                FROM Facturas as fac 
                INNER JOIN Detalles_Facturas as det ON det.factura_id = fac.id
                INNER JOIN Almacen as al ON al.id = det.almacen_id
                INNER JOIN Usuarios as cata ON cata.id = fac.user_id
                WHERE fac.id = '$facturasId'
                "
        ));

        return response()->json([
            "success" => true,
            "data" => $data
        ]);
    }
}
