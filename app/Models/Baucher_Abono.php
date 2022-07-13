<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Baucher_Abono extends Model
{
    use HasFactory;

    protected $table = 'Bauceher_Abono';

    protected $fillable = [
        "name",
        "ruc",
        "total_deuda",
        "monto_abonado",
        "concepto",
        "metodo_pago",
        "deuda",
    ];
}
