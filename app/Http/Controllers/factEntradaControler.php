<?php
namespace App\Http\Controllers;
use App\Detalleventa;
use App\proveedor;
use App\entradafactura;
use App\clientes;
use App\productos;
use App\venta;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\inventarioproducto;
use PDF;
use DB;
class factEntradaControler extends Controller
{
  public function index(Request $request, entradafactura $entradafactura)
  {
    if ($request->ajax())
    { 
      $proveedors = entradafactura::with('inventarioproducto')
      ->with('proveedor')
      //->where('estado',1)
      ->orderBy('estado','DESC')
      ->paginate(6); 
      $codprove = entradafactura::codprove(); 
      $data = ["codprove"=> $codprove,"proveedors"=> $proveedors]; 
      return response()->json($data,200);
    }
    return view('entradafactura.index'); 
  }
  public function create() 
  {
      $proveedor = proveedor::all(); 
      return view('entradafactura.crearentradafactura',compact('proveedor'));
  }
  public function store(Request $request)
  {
    if ($request->ajax()) 
    { 
      $sesion = session('usuario');
      $originalDate = $request->input('fecha_pago');
      $newDate = date("d/m/Y", strtotime($originalDate)); //organisar la fecha 
      $entradafactura = new entradafactura();
      $entradafactura->codigo = $request->input('codigo');
      $entradafactura->proveedor = $request->input('proveedor');
      $entradafactura->pago = $request->input('pago');
      $entradafactura->total_factura = $request->input('total_factura');
      $entradafactura->fecha_ingreso = $request->input('fecha_ingreso');
      $entradafactura->fecha_pago = $newDate;
      $entradafactura->estado = '1';
      $entradafactura->proceso = '0';
      $entradafactura->nom_user = $sesion;
      $entradafactura->slug_entradafactura = Str::of($request->input('codigo')); 
      $entradafactura->save();  
      return response()->json([
          "message"=>"Producto creado",
          "entradafactura"=>$entradafactura,
      ],200);
    }
  }
  public function show($id)
  {
  }
  public function edit($id)
  {
  }
  public function update(Request $request, $id)
  {
  }
  public function destroy(entradafactura $entradafactura)
  {
    $restacantidad = new inventarioproducto(); 
    $restacantidad->where('codigo_factura',$entradafactura->codigo)
    ->delete();
    $entradafactura->delete();
      return response()->json(["message"=>"entradafactura eliminado"],200);
  }
  public function ponerespera()
  {
    $max = entradafactura::max('espera');
    $ponerespera = entradafactura::where('espera','0')->update(['espera'=> $max+1 ]);
  }
  public function pdffacturaventa(Request $request)
  {
    $numerofactura = $request->input('numerofactura');
    $consultaidfactura = venta::where('nfactura',$request->input('numerofactura'))
    ->select('id','codigo_cliente','usuario','modo_pago','total_factura','pago_con','saldo_efectivo')
    ->first();  
    $datosclientes = clientes::where('cedula',$consultaidfactura->codigo_cliente)
    ->select('*')
    ->first(); 
    $detallefacturaventa = Detalleventa::where('id_ventas',$consultaidfactura->id)
    ->select('*')
    ->get();
    $sumaProducto = Detalleventa::where('id_ventas',$consultaidfactura->id)
    ->select(DB::raw('sum(cantidades) as totalproductos' ))
    ->get();  
    //dd($subtotal[0]->total); 
    $contadoritems = Detalleventa::where('id_ventas',$consultaidfactura->id)
    ->count(); 
    $fecha = date("d-m-Y (H:i:s)");
    $data = compact('detallefacturaventa','fecha','numerofactura','datosclientes','consultaidfactura','contadoritems','sumaProducto');
    $pdf = PDF::loadView('pdf.reporteinventario', $data)->setPaper('a4', 'portrait');
    return $pdf->download($request->input('nombrecliente').'_'.$fecha.'.pdf');      
  }
  public function mostartotalinventio(Request $request){
    $mostartotalnue1 = inventarioproducto::where('codigo_factura',$request->dato2)
    ->select(DB::raw('sum(precio_ini * cantidades) as totalproductos' ))
    ->first();   
    $data = ["mostartotalnue1"=> number_format($mostartotalnue1->totalproductos)]; 
    return response()->json($data,200);
  }

}
