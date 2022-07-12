<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vista_Deudas extends Model
{
    use HasFactory;

    protected $table = 'Vista_Deudas';

    protected $fillable = [
        "id",
        "created_at",
        "nombres",
        "ruc",
        "total",
        "SumaAbonos",
        "resta",
        "tienda",
    ];
}
