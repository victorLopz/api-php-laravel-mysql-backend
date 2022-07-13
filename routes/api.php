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
Route::get('/almacen/inversion', $routeAlmacen.'@getInversion');
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
Route::get('/admin/index', $indexTienda.'@admin');
Route::put('/admin/descuento/desactivar/{tipoAlmacenId}/almacen', $indexTienda.'@descuentoDesactivar');
Route::put('/admin/descuento/activar/{tipoAlmacenId}/almacen', $indexTienda.'@descuentoActivar');

// Facturas
$catalogo = 'App\Http\Controllers\CatalogosController';
// Catalogo de producto...
Route::get('/factura/productos', $catalogo.'@productos');
// Revisar si tiene le descuento
Route::get('/factura/descuento', $catalogo.'@verDescuento');

$factura = 'App\Http\Controllers\FacturasController';
Route::post('/factura', $factura.'@create');
Route::post('/factura/detalle', $factura.'@guardarDetalleFactura');
Route::get('/factura', $factura.'@historialFactura');
Route::get('/factura/{facturaId}', $factura.'@verDetallesFacturas');

Route::get('/baucher/factura', $factura.'@tickets');

// Abono
$abonos = 'App\Http\Controllers\HistorialAbonoController';
Route::get('/abonos/cancelados', $abonos.'@vistaDedudasCanceladas');
Route::get('/abonos', $abonos.'@vistaDedudas');
Route::get('/abonos/{facturaId}', $abonos.'@verAbonos');
Route::post('/abonos', $abonos.'@store');
Route::get('/abonos/{facturaId}/descripcion', $abonos.'@descripcion');
Route::get('/baucher-abono', $abonos.'@bacuherAbono');

// Login
$login = 'App\Http\Controllers\UserLoginController';
Route::post('/login', $login.'@store');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
