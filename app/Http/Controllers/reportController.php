<?php

namespace App\Http\Controllers;

use App\Models\Facturas;
use App\Models\Detalles_Facturas;
use App\Models\Almacen;
use App\Models\Almacen_Uno;
use App\Models\Tipo_Almacenes;
use Egulias\EmailValidator\Result\Reason\DetailedReason;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function report(Request $request)
    {

        date_default_timezone_set("America/Costa_Rica"); // ("America/Santiago") por ejemplo
        $timestamp = time();
        $hoy = getdate($timestamp);

        $fecha = $hoy['year'] . "/" . $hoy['mon'] . "/" . $hoy['mday'];

        $data = null;

        if ($request->tipoFactura == 1 ||  $request->tipoFactura == 3) {
            $product = Detalles_Facturas::select(
                "Facturas.id",
                "Facturas.created_at",
                "Detalles_Facturas.unidades",
                "Almacen.nombre_articulo",
                "Almacen.precio_compra",
                "Almacen.precio_venta",
                DB::raw("(Detalles_Facturas.unidades * Almacen.precio_venta) AS total"),
                DB::raw(
                    "(Detalles_Facturas.unidades * Almacen.precio_venta) - (Detalles_Facturas.unidades * Almacen.precio_compra)
                    AS ganancias
                    "
                )
            )
                ->join("Almacen", "Almacen.id", "=", "Detalles_Facturas.almacen_id")
                ->join("Facturas", "Facturas.id", "=", "Detalles_Facturas.factura_id")
                ->where([
                    ["Facturas.tipo_factura", "=", $request->tipoFactura],
                    ["Facturas.is_visible", "=", 1],
                ])
                ->whereBetween("Facturas.created_at", [$request->inicio, $request->final])
                ->get();

            $resultados = Detalles_Facturas::select(
                DB::raw("SUM(Detalles_Facturas.unidades) AS cantidades"),
                DB::raw("SUM(Detalles_Facturas.unidades * Almacen.precio_venta) AS totales"),
                DB::raw("SUM((Detalles_Facturas.unidades * Almacen.precio_venta) - (Detalles_Facturas.unidades * Almacen.precio_compra)) AS suma_venta")
            )->join("Almacen", "Almacen.id", "=", "Detalles_Facturas.almacen_id")
                ->join("Facturas", "Facturas.id", "=", "Detalles_Facturas.factura_id")
                ->where([
                    ["Facturas.tipo_factura", "=", $request->tipoFactura],
                    ["Facturas.is_visible", "=", 1],
                ])
                ->whereBetween("Facturas.created_at", [$request->inicio, $request->final])
                ->first();

            $data = [
                "resultados" => $resultados,
                "products" => $product,
            ];
        } else if ($request->tipoFactura == 0) {
            $product = Detalles_Facturas::select(
                "Facturas.id",
                "Facturas.created_at",
                "Detalles_Facturas.unidades",
                "Almacen.nombre_articulo",
                "Almacen.precio_compra",
                "Almacen.precio_venta",
                DB::raw("(Detalles_Facturas.unidades * Almacen.precio_venta) AS total"),
                DB::raw(
                    "(Detalles_Facturas.unidades * Almacen.precio_venta) - (Detalles_Facturas.unidades * Almacen.precio_compra)
                    AS ganancias
                    "
                )
            )
                ->join("Almacen", "Almacen.id", "=", "Detalles_Facturas.almacen_id")
                ->join("Facturas", "Facturas.id", "=", "Detalles_Facturas.factura_id")
                ->where([
                    ["Facturas.is_visible", "=", 1],
                ])
                ->whereBetween("Facturas.created_at", [$request->inicio, $request->final])
                ->get();

            $resultados = Detalles_Facturas::select(
                DB::raw("SUM(Detalles_Facturas.unidades) AS cantidades"),
                DB::raw("SUM(Detalles_Facturas.unidades * Almacen.precio_venta) AS totales"),
                DB::raw("SUM((Detalles_Facturas.unidades * Almacen.precio_venta) - (Detalles_Facturas.unidades * Almacen.precio_compra)) AS suma_venta")
            )->join("Almacen", "Almacen.id", "=", "Detalles_Facturas.almacen_id")
                ->join("Facturas", "Facturas.id", "=", "Detalles_Facturas.factura_id")
                ->where([
                    ["Facturas.is_visible", "=", 1],
                ])
                ->whereBetween("Facturas.created_at", [$request->inicio, $request->final])
                ->first();

            $data = [
                "resultados" => $resultados,
                "products" => $product,
            ];
        } else if ($request->tipoFactura == 2) {

            $product = Detalles_Facturas::select(
                "Facturas.id",
                "Facturas.created_at",
                "Facturas.total",
                "Facturas.suma_abonos",
                "Detalles_Facturas.unidades",
                "Almacen.nombre_articulo",
                "Almacen.modelo",
                "Almacen.precio_compra",
                "Almacen.precio_venta",
                DB::raw("(Detalles_Facturas.unidades * Almacen.precio_venta) AS total_precio_venta"),
                DB::raw("(Detalles_Facturas.unidades * Almacen.precio_compra) AS total_precio_compra"),
                DB::raw(
                    "(Detalles_Facturas.unidades * Almacen.precio_venta) - (Detalles_Facturas.unidades * Almacen.precio_compra)
                    AS ganancias
                    "
                )
            )
                ->join("Almacen", "Almacen.id", "=", "Detalles_Facturas.almacen_id")
                ->join("Facturas", "Facturas.id", "=", "Detalles_Facturas.factura_id")
                ->where([
                    ["Facturas.tipo_factura", "=", $request->tipoFactura],
                    ["Facturas.is_visible", "=", 1],
                ])
                ->whereBetween("Facturas.created_at", [$request->inicio, $request->final])
                ->whereColumn("Facturas.total", "=", "Facturas.suma_abonos")
                ->get();

            $resultados = Detalles_Facturas::select(
                DB::raw("SUM(Detalles_Facturas.unidades) AS cantidades"),
                DB::raw("SUM(Detalles_Facturas.unidades * Almacen.precio_venta) AS totales"),
                DB::raw("SUM((Detalles_Facturas.unidades * Almacen.precio_venta) - (Detalles_Facturas.unidades * Almacen.precio_compra)) AS suma_venta")
            )->join("Almacen", "Almacen.id", "=", "Detalles_Facturas.almacen_id")
                ->join("Facturas", "Facturas.id", "=", "Detalles_Facturas.factura_id")
                ->where([
                    ["Facturas.tipo_factura", "=", $request->tipoFactura],
                    ["Facturas.is_visible", "=", 1],
                ])
                ->whereBetween("Facturas.created_at", [$request->inicio, $request->final])
                ->whereColumn("Facturas.total", "=", "Facturas.suma_abonos")
                ->first();

            $data = [
                "resultados" => $resultados,
                "products" => $product,
            ];
        }

        return response()->json([
            "data" => $data,
        ]);
    }
}
