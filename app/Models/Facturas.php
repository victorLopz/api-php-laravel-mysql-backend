<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facturas extends Model
{
    use HasFactory;

    protected $fillable = [
        "iva",
        "sub_total",
        "total",
        "monto_pagado",
        "cambio",
        "suma_abonos",
        "tipo_almacen_id",
        "user_id",
        "tipo_factura",
    ];
}
