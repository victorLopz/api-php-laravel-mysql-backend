<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipos_Facturas extends Model
{
    use HasFactory;

    protected $table = 'Tipo_Facturas';

    protected $fillable = [
        "nombres"
    ];
}
