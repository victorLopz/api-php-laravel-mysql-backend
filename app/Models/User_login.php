<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_login extends Model
{
    use HasFactory;

    protected $table = 'User_Login';

    protected $fillable = [
        "user_name",
        "user_password",
        "shop",
        "is_visible",
        "tipo_almacen_id"
    ];
}
