<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Creditos_Cancelados extends Model
{
    use HasFactory;

    protected $table = 'Creditos_Cancelados';

    protected $fillable = [
        'id',
        'created_at',
        'nombres',
        'ruc',
        'total',
        'suma_abonos',
        'resta',
        'tienda',
    ];
}
