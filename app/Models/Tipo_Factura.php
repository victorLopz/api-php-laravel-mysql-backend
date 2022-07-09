<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_Factura extends Model
{
    use HasFactory;
    protected $fillable = [
        "rol",
        "nivel",
        "nombre_almacen",
        "descuento"
    ];
}
