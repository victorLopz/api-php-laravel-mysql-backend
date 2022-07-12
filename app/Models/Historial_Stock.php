<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historial_Stock extends Model
{
    use HasFactory;

    protected $table = 'Historial_Stocks';

    protected $fillable = [
        "tipo_almacen_id",
        "almacen_id",
        "cantidades"
    ];
}
