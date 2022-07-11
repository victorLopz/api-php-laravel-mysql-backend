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
$routerUser = 'App\Http\Controllers\UsuariosController';
Route::post('/usuarios', $routerUser.'@store');
Route::get('/usuarios', $routerUser.'@index');
Route::patch('/usuarios', $routerUser.'@edit');
Route::patch('/usuarios/{id}', $routerUser.'@update');

// Almacen uno
$routeAlmacenUno = 'App\Http\Controllers\AlmacenUnoController';
Route::post('/almacen-uno/stock', $routeAlmacenUno.'@addStock');

// Index tienda
$indexTienda = 'App\Http\Controllers\indexController';
Route::get('/almacen-uno/index', $indexTienda.'@tienda');
Route::get('/admin/index', $indexTienda.'@admin');
Route::put('/admin/descuento/desactivar/{tipoAlmacenId}/almacen', $indexTienda.'@descuentoDesactivar');
Route::put('/admin/descuento/activar/{tipoAlmacenId}/almacen', $indexTienda.'@descuentoActivar');

// Facturas
$factura = 'App\Http\Controllers\CatalogosController';
Route::get('/factura/productos', $factura.'@productos');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
