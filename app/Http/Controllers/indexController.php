<?php

namespace App\Http\Controllers;

use App\Models\Facturas;
use App\Models\Detalles_Facturas;
use App\Models\Almacen;
use App\Models\Almacen_Uno;
use App\Models\Tipo_Almacenes;
use Illuminate\Support\Facades\DB;
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
        $almacen = Detalles_Facturas::select("Almacen.nombre_articulo, Detalles_Facturas.almacen_id")
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

        date_default_timezone_set("America/Costa_Rica"); // ("America/Santiago") por ejemplo
        $timestamp = time();
        $hoy = getdate($timestamp);

        $fecha = $hoy['year'] . "/" . $hoy['mon'] . "/" . $hoy['mday'];

        $stockQuantity = Almacen_Uno::select("stock")->where('is_visible', 1)->count();

        $datos = DB::select(DB::raw(
            "
        SELECT
            sum(al.precio_venta * (aluno.stock)) as venta,
            sum(al.precio_compra  * (aluno.stock)) as compra,
            (sum(al.precio_venta * (aluno.stock)) - sum(al.precio_compra  * (aluno.stock))) as ganancias
        from
            Almacen as al
        INNER JOIN Almacen_Uno as aluno ON
            aluno.almacen_id = al.id
        WHERE
            al.is_visible = 1
            AND aluno.stock > 0
        "
        ));

        $dineroCaja = Facturas::where([
            ['is_visible', '=', 1],
            ['created_at', '=', $fecha]
        ])->sum('suma_abonos');

        $ventasDia = Facturas::where([
            ['is_visible', '=', 1],
            ['created_at', '=', $fecha]
        ])->count('id');

        $tienda = Tipo_Almacenes::where([
            ['nivel', '=', '2']
        ])->first();

        $inversion = DB::select(DB::raw(
            "SELECT sum(al.precio_compra * aluno.stock) as inversion 
                FROM Almacen as al INNER JOIN Almacen_Uno as aluno ON al.id = aluno.almacen_id 
                WHERE al.is_visible = 1 AND aluno.stock > 0"
        ));

        return response()->json([
            "usuarios" => 2,
            "cantidadProductos" => $stockQuantity,
            "dineroCaja" => $dineroCaja,
            "ventasDia" => $ventasDia,
            "venta" => $datos[0]->venta,
            "compra" => $datos[0]->compra,
            "ganancias" => $datos[0]->ganancias,
            "almacenUnoDescuentoId" => $tienda->id,
            "almacenUnoDescuentoBoolean" => $tienda->descuento,
            "inversion" => $inversion[0]->inversion
        ]);
    }

    public function descuentoDesactivar($tipoAlmacenId){
        $tienda = Tipo_Almacenes::where('id', $tipoAlmacenId)->first();
        $tienda->descuento = false;
        $tienda->save();

        return response()->json([
            "success" => true
        ]);
    }

    public function descuentoActivar($tipoAlmacenId){
        $tienda = Tipo_Almacenes::where('id', $tipoAlmacenId)->first();
        $tienda->descuento = true;
        $tienda->save();

        return response()->json([
            "success" => true
        ]);
    }
}
