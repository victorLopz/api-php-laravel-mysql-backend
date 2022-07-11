<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalles_Facturas extends Model
{
    use HasFactory;

    protected $table = 'Detalles_Facturas';

    protected $fillable = [
        "unidades",
        "precio_compra",
        "precio_venta",
        "factura_id",
        "almacen_id"
    ];
}
