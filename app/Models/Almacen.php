<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    use HasFactory;

    protected $table = 'Almacen';

    protected $fillable = [
        "codigo1",
        "codigo2",
        "nombre_articulo",
        "marca",
        "modelo",
        "precio_venta",
        "precio_compra",
        "precio_ruta_uno",
        "precio_ruta_dos",
        "notas",
        "is_visible"
    ];
}
