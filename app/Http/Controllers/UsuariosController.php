<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
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
        $request->validate([
            "nombres" => ['required'],
            "apellidos",
            "telefono",
            "email" => ['required'],
            "ruc" => ['required'],
            "direccion" => ['required'],
        ]);

        $email = Usuarios::where('email', '=', $request->email)->first();

        if ($email !== null) {
            $msg = ["msg" => "El usuario ya existe"];
            return response($msg, 404);
        }

        $usuario = new Usuarios;
        $usuario->nombres = $request->nombres;
        $usuario->apellidos = $request->apellidos;
        $usuario->telefono = $request->telefono;
        $usuario->email = $request->email;
        $usuario->ruc = $request->ruc;
        $usuario->direccion = $request->direccion;
        $usuario->is_visible = true;
        $usuario->save();

        return response()->json([
            "user" => $usuario
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Usuarios  $usuarios
     * @return \Illuminate\Http\Response
     */
    public function show(Usuarios $usuarios)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Usuarios  $usuarios
     * @return \Illuminate\Http\Response
     */
    public function edit(Usuarios $usuarios, $id)
    {
        $Usuario = Usuarios::where('id', '=', $id)->first();

        if ($Usuario == null) {
            $msg = ["msg" => "El Usuario no existe"];
            return response($msg, 404);
        }

        /* Updating the product to be invisible. */
        $Usuario = Usuarios::where('id', '=', $id)->first();
        $Usuario->is_visible = false;
        $Usuario->save();

        return response()->json([
            "msg" => "Usuario eliminado correctamente"
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Usuarios  $usuarios
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Usuarios $usuarios, $id)
    {
        //
        $user = Usuarios::where('id', '=', $id)->first();

        if ($user == null) {
            $msg = ["msg" => "El usuario no existe"];
            return response($msg, 404);
        };

        $user = Usuarios::where('id', '=', $request->id)->first();
        $user->nombre =  $request->nombre;
        $user->apellidos = $request->apellidos;
        $user->telefono = $request->telefono;
        $user->email = $request->email;
        $user->ruc = $request->ruc;
        $user->direccion = $request->direccion;
        $user->save();

        return response()->json([
            "user" => $user
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Usuarios  $usuarios
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usuarios $usuarios)
    {
        //
    }
}
