<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacen_Uno extends Model
{
    
    use HasFactory;

    protected $table = 'Almacen_Uno';

    protected $fillable = [
        "stock",
        "is_visible",
        "almacen_id"
    ];
}
