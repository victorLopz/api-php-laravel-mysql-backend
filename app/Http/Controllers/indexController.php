<?php

namespace App\Http\Controllers;
use App\Models\Facturas;
use App\Models\Detalles_Facturas;
use App\Models\Almacen;
use App\Models\Almacen_Uno;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tienda()
    {
        //
        $almacen = Detalles_Facturas::
        select("Almacen.nombre_articulo, Detalles_Facturas.almacen_id")
        ->innerJoin('Almacen', 'Almacen.id', '=', 'Detalles_Facturas.almacen_id')
        ->innerJoin('Facturas', 'Facturas.id', '=', 'Detalles_Facturas.factura_id')
        ->groupBy('date')
        ->orderBy('Detalles_Facturas.almacen_id', 'DESC')
        ->first();

        return response()->json([
            $almacen
        ]);
    }

    public function admin()
    {

        $stockQuantity = Almacen_Uno::select("stock")->where('is_visible', 1)->count();
        
        $costos = Almacen::selectRaw("Almacen.precio_compra * Almacen_Uno.stock")
        ->where('Almacen.is_visible', 1)
        ->innerJoin('Almacen_Uno', 'Almacen_Uno.almacen_id', '=', 'Almacen.id');


        $ventas = Almacen::where('is_visible', 1)->sum("precio_venta");

        return response()->json([
            "stock-quantity" => $stockQuantity,
            "costos" => $costos,
            "ventas" => $ventas
        ]);
    }
}
