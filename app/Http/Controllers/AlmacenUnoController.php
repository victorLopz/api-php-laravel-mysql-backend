<?php

namespace App\Http\Controllers;

use App\Models\Almacen_Uno;
use Illuminate\Http\Request;
use App\Models\Historial_Stock;

class AlmacenUnoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Almacen_Uno  $almacen_Uno
     * @return \Illuminate\Http\Response
     */
    public function show(Almacen_Uno $almacen_Uno)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Almacen_Uno  $almacen_Uno
     * @return \Illuminate\Http\Response
     */
    public function edit(Almacen_Uno $almacen_Uno)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Almacen_Uno  $almacen_Uno
     * @return \Illuminate\Http\Response
     */
    public function addStock(Request $request, Almacen_Uno $almacen_Uno)
    {
        //
        $product = Almacen_Uno::where('id', '=', $request->id)->first();
        $product->stock = $request->stock + $product->stock;
        $product->save();

        $HistorialStock = new Historial_Stock();
        $HistorialStock->tipo_almacen_id = 1;
        $HistorialStock->almacen_id = $request->id;
        $HistorialStock->cantidades = $request->stock;
        $HistorialStock->save();

        return response()->json([
            "success" => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Almacen_Uno  $almacen_Uno
     * @return \Illuminate\Http\Response
     */
    public function destroy(Almacen_Uno $almacen_Uno)
    {
        //
    }
}
