<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_Almacenes extends Model
{
    use HasFactory;

    protected $table = 'Tipos_Almacenes';

    protected $fillable = [
        "rol",
        "nivel",
        "nombre_almacen",
        "descuento"
    ];
}
