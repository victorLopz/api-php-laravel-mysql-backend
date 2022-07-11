<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Almacen;
use App\Models\Tipo_Almacenes;

class CatalogosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function productos()
    {
        //
        $almacen = Almacen::select(
            "Almacen.id",
            "Almacen.codigo1",
            "Almacen.nombre_articulo",
            "Almacen.modelo",
            "Almacen.marca",
            "Almacen.precio_venta",
            "Almacen_Uno.stock"
        )->leftJoin('Almacen_Uno', 'Almacen_Uno.almacen_id', '=', 'Almacen.id')
        ->where([
            ['Almacen.is_visible', '=', 1],
            ['Almacen_Uno.stock', '>', 1]
        ])->get();

        return response()->json([
            "products" => $almacen
        ]);
    }

    public function verDescuento(){
        $descuento = Tipo_Almacenes::where("nivel", 2)->first();

        return response()->json([
            $descuento
        ]);
    }
}
