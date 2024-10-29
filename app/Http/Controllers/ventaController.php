<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\venta;
use App\Detalleventa;
use App\productos;
use App\clientes;
use App\Devolucion;
use Illuminate\Support\Facades\DB;

class ventaController extends Controller
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
            $esperaventa = venta::leftjoin("detalleventas as kmc", "ventas.id","=","kmc.id_ventas")
            ->select("ventas.nespera", DB::raw('round(ifnull(sum(precio * cantidades),0),2) as total' )) 
            ->where('ventas.nespera','>',0)
            ->where('nfactura','=',null)
            ->groupBy('ventas.id')
            ->get(); 
            $busquecarprod = productos::select('*')
            ->orderBy('codigo','DESC')
            ->get();
            $mostarproductotabla = productos::select('*')
            ->orderBy('nombre','ASC')
            ->take(13)
            ->get(); 
            $data = ["esperaventa"=> $esperaventa,"busquecarprod"=> $busquecarprod,"mostarproductotabla"=> $mostarproductotabla]; 
            return response()->json($data,200);
        };
        return view('venta.index');
    }
    public function mostarespra(Request $request)
    {
         if ($request->ajax())
        { 
            $numeroespera = $request->input('nesperaen');
            $id_factura_cotisacion = venta::select('id')
            ->where('nespera',$numeroespera)
            ->get();
            $id_factura_cotisacion = $id_factura_cotisacion[0]->id;
            $ventaespera = Detalleventa::where('id_ventas',$id_factura_cotisacion)
            ->orderBy('id','DESC')
            ->get(); 
            $totalfactura_venta = Detalleventa::where('id_ventas', '=', $id_factura_cotisacion)
            ->select(DB::raw('round(sum(precio * cantidades),2) as total' ))
            ->first();
            $totalproducto_venta = Detalleventa::where('id_ventas', '=', $id_factura_cotisacion)
            ->select(DB::raw('sum(cantidades) as totalproductos' ))
            ->first(); 

            $data = ["ventaespera"=> $ventaespera,"numeroespera"=> $numeroespera, "totalfactura_venta" => $totalfactura_venta->total, "totalproducto_venta" => $totalproducto_venta->totalproductos]; 
            return response()->json($data,200);

        }
        return view('venta.index',compact('data'));
    }
    public function craerspera(Request $request)
    {
      if ($request->ajax())
      {
        
        $sesion = session('usuario');
        $codigoproducto = $request->input('codigoenv'); 
        $codigoenuso = $request->input('codigoenuso');
        $consultarproducto = productos::where('codigo',$codigoproducto)
        ->get();  

        if (empty($consultarproducto[0])) 
        {
          return response()->json("nada",200); 
        }
        else
        {
          if ($codigoenuso == 0) 
          { 
            $numeroesperacero = venta::select('*')
            ->where('total_factura', '<=','0')
            ->first(); 
            if ($numeroesperacero == null) 
            {
              $numeroespera = venta::select(DB::raw('max(nespera)+1 as numero_espera' ))
              ->first(); 
              
              if ($numeroespera['numero_espera'] == null) 
              {
                  $numeroespera['numero_espera'] = 1;
              }
              $insertnspera = new venta();
              $insertnspera->nespera = $numeroespera['numero_espera'];
              $insertnspera->usuario = $sesion;
              $insertnspera->total_factura = '0';
              $insertnspera->save();
              $codigo_atrabajar = $insertnspera->nespera;
              $id_factura_cotisacion = $insertnspera->codigo_cliente;
            }
            else
            {
              $codigo_atrabajar = $numeroesperacero->nespera;
              $id_factura_cotisacion = $numeroesperacero->id;
            }
          }
          else
          {
            $codigo_atrabajar = $codigoenuso;
            $id_factura_cotisacion = venta::select('id')
            ->where('nespera',$codigo_atrabajar)
            ->get(); 
            $id_factura_cotisacion = $id_factura_cotisacion[0]->id;
          }
          $insertnspera = new Detalleventa();
          $insertnspera->id_ventas = $id_factura_cotisacion;
          $insertnspera->codigo = $codigoproducto;
          $insertnspera->nombre = $consultarproducto[0]->nombre;
          $insertnspera->precio = $consultarproducto[0]->precio_final;
          $insertnspera->cantidades = '1';
          $insertnspera->save(); 
            // $ventaespera 
          $ventaespera = Detalleventa::where('id_ventas',$id_factura_cotisacion)
          ->orderBy('id','DESC')
          ->get(); 
          //$totalfactura_venta suma total de venta por numero de espera
          $totalfactura_venta = Detalleventa::where('id_ventas', '=', $id_factura_cotisacion)
          ->select(DB::raw('round(sum(precio * cantidades),2) as total' ))
          ->first(); 
          $totalproducto_venta = Detalleventa::where('id_ventas', '=', $id_factura_cotisacion)
          ->select(DB::raw('sum(cantidades) as totalproductos' ))
          ->first();

          $data = ["codigo_atrabajar"=> $codigo_atrabajar,"ventaespera"=> $ventaespera,"totalfactura_venta"=> $totalfactura_venta->total, "totalproducto_venta" => $totalproducto_venta->totalproductos,"consultarproducto"=> $consultarproducto]; 
          return response()->json($data,200);
        }
        
      }
      return view('venta.index',compact('data'));
    }

    public function eliminarproventa(Request $request)
    {
         $id = $request->input('id');        
    }
    public function cargarproductoventa(Request $request) 
    { 
      if ($request->ajax())
      {  
        $elementosa = $request->params["data"];        
        if ($elementosa !== null ) 
        { 
          $contarreguistro = count($elementosa);
          $contado = 0; 
          for ($i=0; $i < $contarreguistro ; $i++) {
            $elementos = $elementosa[$i];          
            /*actualisa los reguistro antes de procesar*/
            $inventarioproducto = new Detalleventa(); 
            $inventarioproducto->where('id',$elementos["id"])
            ->where('id_ventas',$elementos["id_ventas"])
            ->where('codigo',$elementos["codigo"])
            ->update(['cantidades' => $elementos["cantidades"]]);
            $contado += $elementos["precio"] * $elementos["cantidades"];    
          }
          $esperaventa = venta::leftjoin("detalleventas as kmc", "ventas.id","=","kmc.id_ventas")
          ->select("ventas.nespera", DB::raw('round(ifnull(sum(precio * cantidades),0),2) as total' )) 
          ->where('ventas.nespera','>','0')
          ->where('nfactura','=',null)
          ->groupBy('ventas.id')
          ->get();  
          $venta = new venta();
          $venta->where('id', $request->params["data"][0]['id_ventas'])
          ->update(['total_factura' => 1]); 
          $data = ["esperaventa" =>$esperaventa,"venta" =>$venta]; 
          return response()->json($data,200);  
        } 
      }
      return view('venta.index',compact('data'));
    }
    public function procesarfacturaventa(Request $request)
    { 
      if ($request->ajax())
      { 
        $monto_deuda1 = $request->input('monto_deuda');
        $monto_deuda = str_replace('.', '', $monto_deuda1);
        $codigo_cliente = $request->input('codigo_cliente');
        $totalfactura_venta = $request->input('totalfactura_venta');
        $codigoenuso = $request->input('codigoenuso');
        $pagocon = $request->input('pagocon');
        $modopago = $request->input('modopago');
        if ($modopago == 1) 
        {
          $modopago = 'efectivo';
        }
        else
        {
          $modopago = 'credito';
          $clientes = new clientes();
          $clientes->where('cedula', $request->input('codigo_cliente'))
          ->update(['monto_deuda' => $monto_deuda + $totalfactura_venta]);
        }
        //si el modo de pago es vacio este sera igual al valor total de la venta
        if ($pagocon == '') 
        {
          $pagocon = $totalfactura_venta;
        }
        //se hace una consulta si en la bace de datos no hay una factura creada 
        //para que esta empiese desde 1
        $numerofacturaventa = venta::select(DB::raw('max(nfactura)+1 as numero_factura' ))
        ->first();  
        if ($numerofacturaventa['numero_factura'] == null) 
        {
          $numerofacturaventa['numero_factura'] = 1;
        }
        //se realisa la consulta para saber el monto del cliente 
        $clientes = new clientes();
        $saldo_efectivo = $clientes->where('cedula', $request->input('codigo_cliente'))
        ->select('monto_deuda','lim_max_deuda')
        ->get();
        if ($saldo_efectivo->isEmpty())
        {
          $saldo_montodeuda =  0;
          $saldo_max_deuda =  0;
        }
        else
        {
          $saldo_montodeuda =  $saldo_efectivo[0]->monto_deuda;
          $saldo_max_deuda =  $saldo_efectivo[0]->lim_max_deuda;
          $valortotalacliente = $totalfactura_venta - $pagocon + $saldo_montodeuda;
        }
        //if para saber cual es el modo de pago
        if ($pagocon < $totalfactura_venta ) 
        {
          if ($valortotalacliente > $saldo_max_deuda )
          {
            return response()->json("monto",200);
          }
          else
          {
            $venta = new venta();
            $venta->where('nespera', $request->input('codigoenuso'))
            ->update(['nfactura' => $numerofacturaventa['numero_factura'],'total_factura' => $totalfactura_venta,'pago_con' => $pagocon,'modo_pago' => $modopago,'saldo_efectivo' => $totalfactura_venta - $pagocon,'codigo_cliente' => $codigo_cliente]);
            // se suma el monto ya consultado 
            $clientes = new clientes();
            $clientes->where('cedula', $request->input('codigo_cliente'))
            ->update(['monto_deuda' => $saldo_montodeuda + $totalfactura_venta - $pagocon]);
          }
        }
        else
        {
          //condicion para los modos de pagos efectivo o acredito
          if ($modopago == 'efectivo') {
            $venta = new venta();
            $venta->where('nespera', $request->input('codigoenuso'))
            ->update(['nfactura' => $numerofacturaventa['numero_factura'],'total_factura' => $totalfactura_venta,'pago_con' => $pagocon,'modo_pago' => $modopago,'codigo_cliente' => $codigo_cliente]);
          }
          else
          {
            $venta = new venta();
            $venta->where('nespera', $request->input('codigoenuso'))
            ->update(['nfactura' => $numerofacturaventa['numero_factura'],'total_factura' => $totalfactura_venta,'saldo_efectivo' => $totalfactura_venta,'modo_pago' => $modopago,'codigo_cliente' => $codigo_cliente]);
          }          
        } 
        $nufactura = venta::where('nespera', '=', $codigoenuso)
        ->select(DB::raw('max(nfactura) as nufactura' ))
        ->first();
        $esperaventa = venta::leftjoin("detalleventas as kmc", "ventas.id","=","kmc.id_ventas")
        ->select("ventas.nespera", DB::raw('round(ifnull(sum(precio * cantidades),0),2) as total' )) 
        ->where('ventas.nespera','>',0)
        ->where('nfactura','=',null)
        ->groupBy('ventas.id')
        ->get();
        $data = ["nufactura" => $nufactura->nufactura,"esperaventa" => $esperaventa]; 
        return response()->json($data,200);
      }
      return view('venta.index',compact('data'));
    }
    public function imprimirfacturan(Request $request)
    { 
      if ($request->ajax())
      {  
        // imprimirfactura llega de la ventana de ventas 
        $numerofactura = venta::where('nfactura',$request->input('nfactura'))
        ->take(1)
        ->get();
        $nomcliente = clientes::where('cedula',$numerofactura[0]->codigo_cliente)
        ->select('nombre')
        ->first();

        $imprimirfactura = Detalleventa::where('id_ventas',$numerofactura[0]->id)
        ->orderBy('id','DESC')
        ->get();  
                  
        $data = ["imprimirfactura" => $imprimirfactura, "nomcliente" => $nomcliente->nombre, "numerofactura" => $numerofactura[0]]; 
        return response()->json($data,200);
      }
      return view('venta.index',compact('data'));
    }
    public function borrararticuloventa(Request $request)
    { 
      if ($request->ajax())
      {   
        $id_nespera = venta::where('nespera', $request->input('codigoenuso'))
        ->select('id')
        ->get();  
        $borrararticulos = venta::where('id',$id_nespera[0]->id)
        ->delete();
        $borrararticulos = Detalleventa::where('id_ventas',$id_nespera[0]->id)
        ->delete();

        $esperaventa = venta::leftjoin("detalleventas as kmc", "ventas.id","=","kmc.id_ventas")
        ->select("ventas.nespera", DB::raw('round(ifnull(sum(precio * cantidades),0),2) as total' )) 
        ->where('ventas.nespera','>',0)
        ->where('nfactura','=',null)
        ->groupBy('ventas.id')
        ->get();

        $data = ["esperaventa" => $esperaventa]; 
        return response()->json($data,200);
      }
      return view('venta.index',compact('data'));
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
    public function destroy($id, Detalleventa $Detalleventa)
    { 
        $datos = explode('!!',$id);
        $Detalleventa->where('id',$datos[0])
        ->where('codigo',$datos[1])
        ->delete();
        $cantidad_de_id_ventas = Detalleventa::leftjoin("ventas as kmc","detalleventas.id_ventas","=","kmc.id")
        ->select("detalleventas.id_ventas", DB::raw('sum(detalleventas.cantidades) as total' ))
        ->where('detalleventas.id_ventas','=',$datos[3])
        ->groupBy('detalleventas.id_ventas')
        ->get();

        if (empty($cantidad_de_id_ventas[0]->total)) 
        {
          $venta = new venta();
          $venta->where('id', $datos[3])
          ->update(['total_factura' => 0]);
        }
        return response()->json(["message"=>"eliminado producto venta",
            "Detalleventa"=>$Detalleventa,"nespera"=>$datos[2]],200);
        
    }
//facturas procesadas 
    public function facturaventa(Request $request)
    {
      if ($request->ajax())
      {
            $factura = venta::with('clientes')
            ->where('nfactura', '>', 0)
            ->orderBy('nfactura','DESC')
            ->paginate(5);
          $data = ["factura"=> $factura]; 
          return response()->json($data,200);
      }
      return view('factura.index',compact('data'));
    }
    public function buscarnfactura(Request $request)
    {
      if ($request->ajax())
      { 
        $nfactura = $request->input('nfactura');
        $buscarnfactura = venta::with('clientes')
        ->where('nfactura',$nfactura)
        ->get();
        $data = ["buscarnfactura"=> $buscarnfactura]; 
        return response()->json($data,200);
      }
      return view('factura.index',compact('data'));
    }
    public function facturaprocesada(Request $request)
    { 
        if ($request->ajax())
        {  
            $facturapro = Detalleventa::where('id_ventas',$request->input('id'))
            ->orderBy('id','DESC')
            ->get();
            $totalproducto_venta = Detalleventa::where('id_ventas', '=', $request->input('id'))
            ->select(DB::raw('sum(cantidades) as totalproductos' ))
            ->first();
            $data = ["facturapro"=> $facturapro, "totalproducto_venta" => $totalproducto_venta->totalproductos,]; 
            return response()->json($data,200);
        }
        return view('factura.index',compact('data'));
    }
    public function devolucionespro(Request $request)
    {
        if ($request->ajax())
        { 
            $devolucion = venta::select('ventas.nfactura','detalleventas.codigo','detalleventas.precio','detalleventas.nombre','detalleventas.cantidades','clientes.cedula','clientes.nombre AS ncliente')
            ->join('clientes','ventas.codigo_cliente', '=' ,'clientes.cedula')
            ->join('detalleventas','detalleventas.id_ventas', '=' ,'ventas.id')
            ->where('detalleventas.codigo',$request->input('codigo_producto'))
            ->where('ventas.codigo_cliente',$request->input('codigo_cliente'))
            ->orderBy('ventas.id','DESC')
            ->limit('1')
            ->get();
            $data = ["devolucion"=> $devolucion]; 
            return response()->json($data,200);
        }
        return view('factura.index',compact('data'));
    }
    public function devolucionprod(Request $request)
    {
        if ($request->ajax())
        { 
            $sesion = session('usuario'); 
            $insertardevolucion = new Devolucion();
            $insertardevolucion->nfactura = $request->input('nfactura');
            $insertardevolucion->codigo_cliente = $request->input('codigocliented');
            $insertardevolucion->codigo_producto = $request->input('codigoprod');
            $insertardevolucion->nombre_producto = $request->input('productod');
            $insertardevolucion->precio = $request->input('preciod');
            $insertardevolucion->usuario = $sesion;
            $insertardevolucion->cantidades = $request->input('cantidadinput');
            $insertardevolucion->save(); 
            $venta = new productos();
            $cantidad_producto = productos::where('codigo', $request->input('codigoprod'))
            ->select('cantidades')
            ->get(); 
            $producto = new productos();
            $producto->where('codigo', $request->input('codigoprod'))
            ->update(['cantidades' => $cantidad_producto[0]->cantidades + $request->input('cantidadinput')]);
            $data = ["insertardevolucion"=> $insertardevolucion]; 
            return response()->json($data,200);
        }
        return view('factura.index',compact('data'));
    }
    public function listaproducto(Request $request)
    {
      if ($request->ajax())
      { 
        $listadi_pro = $request->input('nombrepro');
        $listadoproduc = productos::where('nombre','LIKE',"%$listadi_pro%")
        ->orderBy('nombre','ASC')
        ->take(13)
        ->get();
        $data = ["listadoproduc"=> $listadoproduc]; 
        return response()->json($data,200);
      }
      return view('venta.index',compact('data'));
    }
    
}
