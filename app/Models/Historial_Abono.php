<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historial_Abono extends Model
{
    use HasFactory;

    protected $fillable = [
        "factura_id",
        "metodo_pago",
        "concepto",
        "monto_abonado",
    ];
}
