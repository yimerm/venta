<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\caregorias;
use App\productos;
use App\Http\Requests\storeproductosrequest;
use Image;
class productosControler extends Controller
{
    public function index(Request $request)
    {  
      if ($request->ajax()){ 
        $tablaprod = productos::with('categoria') 
        ->orderBy('id','DESC')
        ->paginate(5); 
        $codcategoria = productos::codcategoria();  
        $data = ["tablaprod"=> $tablaprod,"codcategoria"=> $codcategoria]; 
        return response()->json($data,200);
      } 
    return view('productos.index');
    }
    public function create()
    { 
    }
    public function store(Request $request)
    {            
     if ($request->imagenprod == '') 
      { 
        $nomimagen='productos.png';
      }
      else
      {
        $extensionimg = explode('/', mime_content_type($request->imagenprod))[1];
        $nomimagen = time().'.'.$extensionimg;
        \Image::make($request->imagenprod)->save(public_path('/imagenes/').$nomimagen);
        $request->merge(['imagenprod' => $nomimagen]);
      }
      if ($request->ajax()) 
      {
        $validateData = $request->validate(['nombre'=> 'unique:productos']);

        $producto = new productos();
        $producto->codigo = $request->input('codigo');
        $producto->categoria = $request->input('categoria');
        $producto->nombre = $request->input('nombre');
        $producto->precio_ini = $request->input('precio_ini');
        $producto->porcentaje = $request->input('porcentaje');
        $producto->precio_final = $request->input('precio_final');
        $producto->cantidades = '0';
        $producto->total_cantidades = '0';
        $producto->salidas_cantidades = '0'; 
        $producto->imagenprod = $nomimagen;
        $producto->slug_pro = Str::of($request->input('codigo'))->slug('-');
        $producto->save(); 
        $productos = productos::with('categoria')->where('productos.slug_pro', $producto->slug_pro)->first();
        return response()->json([
            "message"=>"Producto creado",
            "producto"=>$producto
          ],200);
      }
    }
    public function show(Request $request,$id)
    {
      if ($request->ajax()){ 
        //buscar codigo en tabla producto para inventarias
        $contar = productos::where('codigo',$id)->get()->count();
        $tablaprod = productos::where('codigo',$id)->get(); 
        //dd($tablaprod);
        $data = ["tablaprod"=> $tablaprod,"contar"=>$contar]; 
        return response()->json($data,200);
      } 
    }
    public function edit(productos $producto)
    { 
    }
    public function update(Request $request, productos $producto)
    {
      if($request->imagenprod == '')
      {
        $producto->update([
        'codigo' => request('codigo'),
        'categoria' => request('categoria'),
        'nombre' => request('nombre'),
        'precio_ini' => request('precio_ini'),
        'porcentaje' => request('porcentaje'),
        'precio_final' => request('precio_final'),
        'total_cantidades' => request('cantidades'),
        'slug_pro' => Str::of(request('nombre'))->slug('-'),
        ]);        
      }
      else
      {
        if ($producto->imagenprod <> 'productos.png' ) 
        {
          $file_path = public_path().'/imagenes/'.$producto->imagenprod;
          \File::delete($file_path);
        }
        $extensionac = explode('/', mime_content_type($request->imagenprod))[1];
        $name = time().'.'.$extensionac;
        \Image::make($request->imagenprod)->save(public_path('/imagenes/').$name);
        $request->merge(['imagenprod' => $name]);

        $producto->update([
        'codigo' => request('codigo'),
        'categoria' => request('categoria'),
        'nombre' => request('nombre'),
        'precio_ini' => request('precio_ini'),
        'porcentaje' => request('porcentaje'),
        'precio_final' => request('precio_final'),
        'slug_pro' => Str::of(request('nombre'))->slug('-'),
        'imagenprod' => $name,
        ]);  
      }
      $producto = productos::with('categoria')
      ->where('codigo',request('codigo'))
      ->first();
      $data = ["producto"=> $producto]; 
      return response()->json($data,200); 
    }

    public function destroy(productos $producto)
    {
      if ($producto->imagenprod == 'productos.png' ) 
      {
        $producto->delete();
        return response()->json(["message"=>"Producto eliminado"],200);
      }
      else
      {
        $file_path = public_path().'/imagenes/'.$producto->imagenprod;
        \File::delete($file_path);
        $producto->delete();
        return response()->json(["message"=>"Producto eliminado"],200);
      }
    }
  }
