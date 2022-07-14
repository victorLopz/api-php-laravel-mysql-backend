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
    public function admin()
    {

        date_default_timezone_set("America/Costa_Rica"); // ("America/Santiago") por ejemplo
        $timestamp = time();
        $hoy = getdate($timestamp);

        $fechaHoy = $hoy['year'] . "-" . $hoy['mon'] . "-" . $hoy['mday'];

        $stockQuantity = Almacen_Uno::where('is_visible', 1)->sum("stock");

        $datos = DB::select(DB::raw(
            "SELECT
            sum(al.precio_venta * (aluno.stock)) as venta,
            sum(al.precio_compra  * (aluno.stock)) as compra,
            (sum(al.precio_venta * (aluno.stock)) - sum(al.precio_compra  * (aluno.stock))) as ganancias
        FROM
            Almacen as al
        INNER JOIN Almacen_Uno as aluno ON
            aluno.almacen_id = al.id
        WHERE
            al.is_visible = 1
            AND aluno.stock > 0"
        ));
        
        $dineroCaja = Facturas::select(DB::raw("SUM(suma_abonos) as dinero_caja"))->where([
            ['is_visible', '=', 1],
            ['date_insert', '=', $fechaHoy ]
        ])->first();

        $ventasDia = Facturas::where([
            ['is_visible', '=', 1],
            ['date_insert', '=', $fechaHoy ]
        ])->count('id');

        $tienda = Tipo_Almacenes::where([
            ['nivel', '=', '2']
        ])->first();

        $inversion = DB::select(DB::raw(
            "SELECT sum(al.precio_compra * aluno.stock) as inversion 
                FROM Almacen as al INNER JOIN Almacen_Uno as aluno ON al.id = aluno.almacen_id 
                WHERE al.is_visible = 1 AND aluno.stock > 0"
        ));

        $topVentas = DB::select(DB::raw(
            "SELECT
                al.nombre_articulo,
                deta.almacen_id,
                COUNT(deta.almacen_id) AS total
            FROM
                Detalles_Facturas as deta
            INNER JOIN Facturas as f on
                f.id = deta.factura_id
            INNER JOIN Almacen as al ON
                al.id = deta.almacen_id
            GROUP BY
                deta.almacen_id
            ORDER BY
                total DESC
            LIMIT 1"
        ));

        return response()->json([
            "usuarios" => 2,
            "cantidadProductos" => $stockQuantity,
            "dineroCaja" => $dineroCaja->dinero_caja,
            "ventasDia" => $ventasDia,
            "venta" => $datos[0]->venta,
            "compra" => $datos[0]->compra,
            "ganancias" => $datos[0]->ganancias,
            "almacenUnoDescuentoId" => $tienda->id,
            "almacenUnoDescuentoBoolean" => $tienda->descuento,
            "inversion" => $inversion[0]->inversion,
            "topVentas" =>  $topVentas[0]->nombre_articulo
        ]);
    }

    public function descuentoDesactivar($tipoAlmacenId)
    {
        $tienda = Tipo_Almacenes::where('id', $tipoAlmacenId)->first();
        $tienda->descuento = false;
        $tienda->save();

        return response()->json([
            "success" => true
        ]);
    }

    public function descuentoActivar($tipoAlmacenId)
    {
        $tienda = Tipo_Almacenes::where('id', $tipoAlmacenId)->first();
        $tienda->descuento = true;
        $tienda->save();

        return response()->json([
            "success" => true
        ]);
    }
}
