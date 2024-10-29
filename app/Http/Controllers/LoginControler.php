<?php

namespace App\Http\Controllers;  
use Illuminate\Http\Request;
use App\Usuarios;
use DB;
use App;
use Barryvdh\DomPDF\Facade\Pdf;

class LoginControler extends Controller
{
    public function login(Request $request)
    {
        if ($request->ajax())
        {           
            $usuario = $request->input('usuario');
            $contraseña = $request->input('contraseña');

            $users = DB::table('Usuarios')
            ->where('usuario',$usuario)
            ->where('password',$contraseña)
            ->select(DB::raw('count(*) as usuario'))
            ->first();

            if ($users->usuario < 1) 
            {
                return response()->json("error",200);
            }
            session(["usuario" => $usuario]);
            $data = ["users" => $usuario]; 
            return response()->json($data,200);
             
        }
        return view('venta.index',compact('data'));
    }


}