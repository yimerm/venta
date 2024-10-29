<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\inventarioproducto;
use App\productos;
use App\entradafactura;
use DB; 
class inventarioproduController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 
      if ($request->ajax()){ 
        if($request->input('codigo') <> "null")
        {
          $tablainventariotabla = inventarioproducto::where('codigo_factura',$request->input('codigo'))
          ->orderBy('id','DESC')
          ->paginate(5);
          $totarfactura = inventarioproducto::where('codigo_factura', '=', $request->input('codigo'))
          ->select(DB::raw('sum(precio_ini * cantidades) as total' ))
          ->first();
          $totarproductos = inventarioproducto::where('codigo_factura', '=', $request->input('codigo'))
          ->select(DB::raw('sum(cantidades) as cantidades' ))
          ->first();
          $itemsproductos = inventarioproducto::where('codigo_factura', '=', $request->input('codigo'))
          ->select(DB::raw('count(codigo_producto) as items' ))
          ->first();
          $data = ["tablainventariotabla"=> $tablainventariotabla , "totarfactura"=> $totarfactura->total , "totarproductos"=> $totarproductos->cantidades , "itemsproductos"=> $itemsproductos->items]; 
          return response()->json($data,200);
        }
        else
        {
          $tablainventariotabla = inventarioproducto::all();
          $data = ["tablainventariotabla"=> $tablainventariotabla]; 
          return response()->json($data,200);
        }
      }
      return view('entradafactura.index',compact('tablainventariotabla'));
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
      $antidadespro = $request->input('cantidades');
      $promocionfac = $request->input('promocionfac');
      $cantidadproductolista = inventarioproducto::where('codigo_producto', '=', $request->input('codigo_producto'))
      ->where('codigo_factura', '=', $request->input('codigo_factura'))
      ->select(DB::raw('count(codigo_producto) as conteo' ))
      ->first();
      $cantidades = inventarioproducto::where('codigo_producto', '=', $request->input('codigo_producto'))
      ->where('codigo_factura',$request->input('codigo_factura'))
      ->select('cantidades','promocion')
      ->get(); 
      
      if ($antidadespro == null) {
        $antidadespro = 0;
      }
      if ($promocionfac == null) {
        $promocionfac = 0;
      } 
      if ($cantidadproductolista->conteo == 0) {
        $inventarioproducto = new inventarioproducto();
        $inventarioproducto->codigo_producto = $request->input('codigo_producto');
        $inventarioproducto->codigo_factura = $request->input('codigo_factura');
        $inventarioproducto->nombre_producto = $request->input('nombre_producto');
        $inventarioproducto->precio_ini = $request->input('precio_ini');
        $inventarioproducto->porcentaje = $request->input('porcentaje'); 
        $inventarioproducto->cantidades = $antidadespro;
        $inventarioproducto->promocion = $promocionfac;
        $inventarioproducto->save();
        return response()->json([
          "message"=>"Producto creado",
          "inventarioproducto"=>$inventarioproducto
          ],200);
      }
      else{
        $updatecantprom = new inventarioproducto(); 
        $updatecantprom->where('codigo_factura',$request->input('codigo_factura'))
        ->where('codigo_producto',$request->input('codigo_producto'))
        ->update(['cantidades' => $antidadespro+$cantidades[0]->cantidades,'promocion' => $promocionfac+$cantidades[0]->promocion]);
        return response()->json([
          "message"=>"Producto editado",
          "inventarioproducto"=>$updatecantprom
          ],200);
      }
    }
    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        //
    }
    public function update(Request $request, inventarioproducto $inventarioproducto)
    {    
      $inventarioproducto->update([
        'nombre_producto' => request('nombre_producto'),
        'precio_ini' => request('precio_ini'),
        'porcentaje' => request('porcentaje'),
        'cantidades' => request('cantidades_inventario'),
        'promocion' => request('cantidades_promocion')
      ]); 
      $totalpro = inventarioproducto::where('codigo_factura',$request->input('codigo_factura'))
      ->select(DB::raw('sum(precio_ini * cantidades) as total' ))
      ->groupby('codigo_factura')
      ->first();  
      $data = ["inventarioproducto"=> $inventarioproducto,"totalpro"=> $totalpro->total]; 
      return response()->json($data,200);
    }
    public function destroy(inventarioproducto $inventarioproducto)
    { 
      $inventarioproducto->where('codigo_producto',$inventarioproducto->codigo_producto)
      ->where('codigo_factura',$inventarioproducto->codigo_factura)
      ->where('id',$inventarioproducto->id)
      ->delete();
      return response()->json(["message"=>"entradafactura eliminado",
      "inventarioproducto"=>$inventarioproducto],200);
    }
    public function sumarcantidades(Request $request)
    {
      $restacantidad = new inventarioproducto(); 
      $restacantidad->where('id',$request->input('id'))
      ->where('codigo_producto',$request->input('codigo_producto'))
      ->update(['cantidades' => $request->input('cantidades_inventario')+1]);
      return response()->json([
      "message"=>"Producto creado",
      "restacantidad"=>$restacantidad
      ],200); 
    }
    public function restarcantidades(Request $request)
    {   
      $restacantidad = new inventarioproducto(); 
      $restacantidad->where('id',$request->input('id'))
      ->where('codigo_producto',$request->input('codigo_producto'))
      ->update(['cantidades' => $request->input('cantidades_inventario')-1]);
      if ($request->input('cantidades_inventario') <= 1) 
      {
        $inventarioproducto = new inventarioproducto(); 
        $inventarioproducto->where('id',$request->input('id'))
        ->where('codigo_producto',$request->input('codigo_producto'))
        ->delete();  
      }
      return response()->json([
        "message"=>"Producto creado",
        "restacantidad"=>$restacantidad
      ],200);  
    }
    public function capturartablaproducto(Request $request) 
    {
      $contarreguistro = count($request->params["data"]);
      $elementos = $request->params["data"]; 
      for ($i=0; $i < $contarreguistro ; $i++) 
      {  
        $elemento = $elementos[$i];
        /*select sionar cantidades para poder sumarlas en $productos*/
        $selectcanti = new productos(); 
        $canti = $selectcanti->where('codigo',$elemento["codigo_producto"])
        ->select(['cantidades'])
        ->get();
        $cantidadesantiguas = $canti[0]->cantidades; 
        /*pone la factura como procesada */
        $totalfactura = new entradafactura();
        $totalfactura->where('codigo', $elemento["codigo_factura"])
        ->update(['estado' => 0]);
        /*actualisa los reguistro antes de procesar*/
        $productos = new productos(); 
        $productos->where('codigo',$elemento["codigo_producto"])
        ->update(['nombre' => $elemento["nombre_producto"],'precio_ini' => $elemento["precio_ini"],'porcentaje' => $elemento["porcentaje"],'cantidades' => $cantidadesantiguas + $elemento["cantidades"]+ $elemento["promocion"],'precio_final' => $elemento["precio_ini"] * (($elemento["porcentaje"]/100)+1)]);   
      }
      //
    }
    public function actualisarregistrotabla(Request $request) 
    { 
      $contarreguistro = count($request->params["data"]);
      $elementos = $request->params["data"];
      for ($i=0; $i < $contarreguistro ; $i++) 
      { 
        $elemento = $elementos[$i];
        /*actualisa los reguistro antes de procesar*/
        $inventarioproducto = new inventarioproducto(); 
        $inventarioproducto->where('codigo_producto',$elemento["codigo_producto"])
        ->where('codigo_factura',$elemento["codigo_factura"])
        ->where('id',$elemento["id"])
        ->update(['cantidades' => $elemento["cantidades"],'promocion' => $elemento["promocion"]]);
      }
    }
    public function actualisarprocesoven(Request $request) 
    { 
      $sesion = session('usuario');
      $procesofactura = new entradafactura(); 
        $procesofactura->where('codigo',$request->params["data2"])
        ->update(['proceso' => $request->params["data"],'nom_user' => $sesion]);
    }
    public function buscarnfacturainventario(Request $request)
    {
      if ($request->ajax())
      { 
        $codigo = $request->input('nfactura');
        $buscarnfacturainventario = entradafactura::with('inventarioproducto')
        ->where('codigo','LIKE',"%$codigo%")
        ->take(6)
        ->orderBy('estado','DESC')
        ->get();
        $data = ["buscarnfacturainventario"=> $buscarnfacturainventario]; 
        return response()->json($data,200);
      }
      return view('entradafactura.index',compact('data'));
    }
    public function verificarfactura(Request $request)
    {
      if ($request->ajax())
      { 
        $verificacion = entradafactura::where('codigo', $request->faccodigo)
        ->get();
        $data = ["verificacion"=> $verificacion]; 
        return response()->json($data,200);
      }
      return view('entradafactura.index',compact('data'));
    }
    public function buscarProinventario(Request $request)
    {
      if ($request->ajax())
      { 
        $ProducFAC = $request->input('ProducFAC');
        $codigo = $request->input('codigo');
        $codigo_factura = $request->input('codigo_factura');
        if ($codigo == 1) {
          $buscarnfactura = inventarioproducto::where('codigo_factura',$codigo_factura)
          ->where('codigo_producto',$ProducFAC)
          ->get();
        }
        else {
          $buscarnfactura = inventarioproducto::where('codigo_factura',$codigo_factura)
          ->where('nombre_producto','LIKE',"%$ProducFAC%")
          ->take(6)
          ->get();
        }
        $data = ["buscarnfactura"=> $buscarnfactura]; 
        return response()->json($data,200);
      }
      return view('entradafactura.index',compact('data'));
    }
}
