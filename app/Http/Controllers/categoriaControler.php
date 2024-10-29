<?php
 
namespace App\Http\Controllers;
use App\caregorias; 
use Illuminate\Support\Str;
use Illuminate\Http\Request;
class categoriaControler extends Controller
{
    public function index(Request $request)
    {
      if ($request->ajax()){ 
        $tablacategorias = caregorias::paginate(9);
        $data = ["tablacategorias"=> $tablacategorias]; 
        return response()->json($data,200);
      }
      return view('categoria.index',compact('tablacategorias'));
    }
    public function listacategoria(Request $request)
    {
      $listadi_pro = $request->input('nombrepro');

      if ($listadi_pro == "")
      { 
        
      }
      else
      {
        $listadi_pro = $request->input('nombrepro');
        $listadoproduc = caregorias::where('nombre','LIKE',"%$listadi_pro%")
        ->take(6)
        ->get();
        $data = ["listadoproduc"=> $listadoproduc]; 
        return response()->json($data,200);
      }
      return view('venta.index',compact('data'));
    }
    public function create()
    {   
    }
    public function store(Request $request)
    {
     if ($request->ajax()) 
      {
        $validateData = $request->validate(['nombre'=> 'unique:caregorias']);
        $categoria = new caregorias();
        $categoria->nombre = $request->input('nombre');
        $categoria->slug_categoria = $request->input('nombre');
        $categoria->save(); 
        return response()->json(["message"=>"categoria creado","categoria"=>$categoria
        ],200);
      }
    }
    public function show($id)
    {
        
    }
    public function edit(caregorias $categorium)
    {
    }
    public function update(Request $request,caregorias $categorium)
    {
      $categorium->update([
          'nombre' => request('nombre'),
          'slug_categoria' => request('nombre'),
        ]);
        $data = ["categorium"=> $categorium]; 
        return response()->json($data,200);
    }
    public function destroy(caregorias $categorium)
    {
      $categorium->delete();
      return response()->json(["message"=>"categoria eliminada"],200); 
    }
}
