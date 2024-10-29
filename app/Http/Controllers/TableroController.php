<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\venta;
use App\entradafactura;
use Illuminate\Support\Facades\DB;

class TableroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 
      if ($request->ajax())
      { 
        $fecha = date('Y-m-d');
        $total_factura = venta::whereDate('created_at', $fecha)
        ->where('modo_pago','efectivo')
        ->select(DB::raw('sum(total_factura) as total_factura' ))
        ->get();
        $saldo_efectivo = venta::whereDate('created_at', $fecha)
        ->where('modo_pago','efectivo')
        ->select(DB::raw('sum(saldo_efectivo) as saldo_efectivo' ))
        ->get();
        $total_reporte_efectivo = $total_factura[0]->total_factura - $saldo_efectivo[0]->saldo_efectivo;
        //-------------------------------------------//
        $saldo_credito = venta::whereDate('created_at', $fecha)
        ->where('modo_pago','credito')
        ->select(DB::raw('sum(total_factura) as credito' ))
        ->get();
        $saldo_efectivo_credito = venta::whereDate('created_at', $fecha)
        ->where('modo_pago','efectivo')
        ->select(DB::raw('sum(saldo_efectivo) as saldo_efectivo' ))
        ->get();
        $total_saldo_credito = $saldo_credito[0]->credito + $saldo_efectivo_credito[0]->saldo_efectivo;
        //---------------------------------------------//
        /*$saldo_credito = entradafactura::whereDate('created_at', $fecha)
        ->where('pago','Efectivo')
        ->select(DB::raw('sum(total_factura) as credito' ))
        ->get();*/

        $data = ["total_reporte_efectivo"=> $total_reporte_efectivo,"saldo_credito"=> $total_saldo_credito]; 
        return response()->json($data,200);
      };
      return view('tablero.tablero',compact('total_factura'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
