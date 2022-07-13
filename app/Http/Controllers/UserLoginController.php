<?php

namespace App\Http\Controllers;

use App\Models\Tipo_Almacenes;
use App\Models\User_login;
use Illuminate\Http\Request;

class UserLoginController extends Controller
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
        $login = User_login::where([
            ["user_name", "=", $request->email],
            ["user_password", "=", $request->password]
        ])->first();

        if ($login == null) {
            $msg = [
                "success" => false,
                "msg" => "Credenciales invalidas"
            ];
            return response($msg, 404);
        }

        $nivel = Tipo_Almacenes::where("nivel", $login->tipo_almacen_id)->first();

        return response()->json([
            "success" => true,
            $nivel
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User_login  $user_login
     * @return \Illuminate\Http\Response
     */
    public function show(User_login $user_login)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User_login  $user_login
     * @return \Illuminate\Http\Response
     */
    public function edit(User_login $user_login)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User_login  $user_login
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User_login $user_login)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User_login  $user_login
     * @return \Illuminate\Http\Response
     */
    public function destroy(User_login $user_login)
    {
        //
    }
}
