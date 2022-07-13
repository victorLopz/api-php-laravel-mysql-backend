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
    public function report()
    {

        date_default_timezone_set("America/Costa_Rica"); // ("America/Santiago") por ejemplo
        $timestamp = time();
        $hoy = getdate($timestamp);

        $fecha = $hoy['year'] . "/" . $hoy['mon'] . "/" . $hoy['mday'];

        $data = Detalles_Facturas::select(
            "Detalles_Facturas.unidades",
            "Almacen.nombre_articulo",
            "Almacen.precio_compra",
            "Almacen.precio_venta",
            DB::raw("(Detalles_Facturas.unidades * Almacen.precio_venta) AS total")
        )->join("Almacen", "Almacen.id", "=", "Detalles_Facturas.almacen_id")->join("Facturas", "Facturas.id", "=", "Detalles_Facturas.factura_id");

        return response()->json([
            "Data" => $data,
        ]);
    }
}
