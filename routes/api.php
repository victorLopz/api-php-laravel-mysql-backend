<?php

use App\Http\Controllers\AlmacenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Almacen -> Productos
$routeAlmacen = 'App\Http\Controllers\AlmacenController';
Route::get('/almacen', $routeAlmacen.'@index');
Route::post('/almacen', $routeAlmacen.'@store');
Route::put('/almacen', $routeAlmacen.'@edit' );
Route::patch('/almacen/{id}', $routeAlmacen.'@update');
Route::get('/almacen/{id}', $routeAlmacen.'@show' );

// Usuarios
$routeAlmacen = 'App\Http\Controllers\UsuariosController';
Route::post('/usuarios', $routeAlmacen.'@store');
Route::patch('/usuarios', $routeAlmacen.'@edit');
Route::patch('/usuarios/{id}', $routeAlmacen.'@update');



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
