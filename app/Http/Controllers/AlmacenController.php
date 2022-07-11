<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\Almacen_Uno;
use Illuminate\Http\Request;

class AlmacenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $almacen = Almacen::select(
            "Almacen.id",
            "Almacen.codigo1",
            "Almacen.codigo2",
            "Almacen.nombre_articulo",
            "Almacen.modelo",
            "Almacen.marca",
            "Almacen.precio_venta",
            "Almacen.precio_compra",
            "Almacen.precio_ruta_uno",
            "Almacen.precio_ruta_dos",
            "Almacen.notas",
            "Almacen_Uno.Stock"
        )->leftJoin('Almacen_Uno', 'Almacen_Uno.almacen_id', '=', 'Almacen.id')
        ->where('Almacen.is_visible', 1)->get();

        return response()->json([
            'Products' => $almacen
        ]);;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            "codigo1" => ['required'],
            "codigo2",
            "nombre_articulo" => ['required'],
            "marca" => ['required'],
            "modelo" => ['required'],
            "precio_venta" => ['required'],
            "precio_compra" => ['required'],
            "precio_ruta_uno" => ['required'],
            "precio_ruta_dos" => ['required'],
            "stock" => ['required'],
            "is_visible" => ['required'],
            "notas",
        ]);

        $validateCodigo1 = Almacen::where('codigo1', '=', $request->codigo1)->first();

        if ($validateCodigo1 !== null) {
            $msg = ["msg" => "El producto ya existe"];
            return response($msg, 404);
        }

        $almacen = Almacen::create($request->post());

        Almacen_Uno::create([
            "stock" => $request->stock,
            "is_visible" => true,
            "almacen_id" => $almacen->id
        ]);

        return response()->json([
            'message' => 'Product Created Successfully!!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $producto = Almacen::select(
            "Almacen.id",
            "Almacen.codigo1",
            "Almacen.codigo2",
            "Almacen.nombre_articulo",
            "Almacen.modelo",
            "Almacen.marca",
            "Almacen.precio_venta",
            "Almacen.precio_compra",
            "Almacen.precio_ruta_uno",
            "Almacen.precio_ruta_dos",
            "Almacen.notas",
            "Almacen_Uno.Stock"
        )->where('Almacen.id', '=', $id)
        ->leftJoin('Almacen_Uno', 'Almacen_Uno.almacen_id', '=', 'Almacen.id')
        ->first();

        return response()->json([
            "product" => $producto
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
        $request->validate([

            "id" => ['required'],
            "codigo1" => ['required'],
            "codigo2",
            "nombre_articulo" => ['required'],
            "marca" => ['required'],
            "modelo" => ['required'],
            "precio_venta" => ['required'],
            "precio_compra" => ['required'],
            "precio_ruta_uno" => ['required'],
            "precio_ruta_dos" => ['required'],
            "stock" => ['required'],
            "notas",

        ]);

        $producto = Almacen::where('id', '=', $request->id)->first();

        if ($producto == null) {
            $msg = ["msg" => "El producto no existe"];
            return response($msg, 404);
        }

        /* Updating the product to be invisible. */
        $producto = Almacen::where('id', '=', $request->id)->first();
        $producto->codigo1 =  $request->codigo1;
        $producto->codigo2 = $request->codigo2;
        $producto->nombre_articulo = $request->nombre_articulo;
        $producto->marca = $request->marca;
        $producto->modelo = $request->modelo;
        $producto->precio_venta = $request->precio_venta;
        $producto->precio_compra = $request->precio_compra;
        $producto->precio_ruta_uno = $request->precio_ruta_uno;
        $producto->precio_ruta_dos = $request->precio_ruta_dos;
        $producto->notas = $request->notas;
        $producto->save();

        $almacenUno = Almacen_Uno::where('almacen_id', '=', $request->id)->first();
        $almacenUno->stock = $request->stock;
        $almacenUno->save();

        $producto = Almacen::select(
            "Almacen.id",
            "Almacen.codigo1",
            "Almacen.codigo2",
            "Almacen.nombre_articulo",
            "Almacen.modelo",
            "Almacen.marca",
            "Almacen.precio_venta",
            "Almacen.precio_compra",
            "Almacen.precio_ruta_uno",
            "Almacen.precio_ruta_dos",
            "Almacen.notas",
            "Almacen_Uno.Stock"
        )->where('Almacen.id', '=', $request->id)
        ->leftJoin('Almacen_Uno', 'Almacen_Uno.almacen_id', '=', 'Almacen.id')
        ->first();

        return response()->json([
            "msg" => "Producto Actualizado correctamente",
            "product" => $producto
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Almacen $category, $id)
    {
        //
        $producto = Almacen::where('id', '=', $id)->first();

        if ($producto == null) {
            $msg = ["msg" => "El producto no existe"];
            return response($msg, 404);
        }

        /* Updating the product to be invisible. */
        $producto = Almacen::where('id', '=', $id)->first();
        $producto->is_visible = false;
        $producto->save();

        return response()->json([
            "msg" => "Producto eliminado correctamente"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Almacen $category)
    {
        //
    }
}
