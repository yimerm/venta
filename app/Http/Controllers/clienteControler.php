<?php

namespace App\Http\Controllers;
use App\clientes; 
use Illuminate\Http\Request;
use App\Http\Requests\StoreClientesRequest;
use Illuminate\Support\Str;

class clienteControler extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $tablaclientes = clientes::paginate(5);
            $data = ["tablaclientes"=> $tablaclientes]; 
            return response()->json($data,200);
        }
        return view('clientes.index',compact('tablaclientes'));
    }

    public function create()
    {
        return view('clientes.crearcliente');
    }

    public function store(Request $request)
    {
        if ($request->imagencliente == '') 
        { 
            $nombreimg='usuario.png';
        }
         else
        {
            $extensionimg = explode('/', mime_content_type($request->imagencliente))[1];
            $nombreimg = time().'.'.$extensionimg;
            \Image::make($request->imagencliente)->save(public_path('/imagenes/clientes/').$nombreimg);
            $request->merge(['imagencliente' => $nombreimg]);
        }
        if ($request->ajax()) 
        { 
            $validateData = $request->validate(['cedula'=> 'unique:clientes']);
            $cliente = new clientes();
            $cliente->cedula = $request->input('cedula');
            $cliente->nombre = $request->input('nombre');
            $cliente->apellidos = $request->input('apellidos');
            $cliente->celular = $request->input('celular');
            $cliente->direcion = $request->input('direcion');
            $cliente->monto_deuda = 0;
            $cliente->lim_max_deuda = $request->input('monto_deuda');
            $cliente->slug_clientes = $request->input('cedula');
            $cliente->imagencliente = $nombreimg;
            $cliente->save(); 
            return response()->json([
                "message"=>"cliente creado",
                "cliente"=>$cliente
            ],200);
         }
    }

    public function show(Request $request,$id)
    { 
        if ($request->ajax()){ 
            //buscar cliente para cargar total de la factura
            $codigocliente = clientes::where('cedula',$id)
            ->get(); 
            $data = ["codigocliente"=> $codigocliente]; 
            return response()->json($data,200); 
        } 
    }

    public function edit(clientes $cliente)
    {
    }

    public function update(Request $request, clientes $cliente)
    {
        if($request->imagencliente == '')
        { 
            $cliente->update([

            'cedula' => request('cedula'),
            'nombre' => request('nombre'),
            'apellidos' => request('apellidos'),
            'celular' => request('celular'),
            'direcion' => request('direcion'),
            'monto_deuda' => request('monto_deuda'),
            'slug_clientes' => Str::of(request('cedula'))->slug('-'),
            ]);        
        }
        else
        { 
            if ($cliente->imagencliente <> 'usuario.png' ) 
            {
                $file_path = public_path().'/imagenes/clientes/'.$cliente->imagencliente;
                \File::delete($file_path);
            }
            $extensionac = explode('/', mime_content_type($request->imagencliente))[1];
            $name = time().'.'.$extensionac;
            \Image::make($request->imagencliente)->save(public_path('/imagenes/clientes/').$name);
            $request->merge(['imagencliente' => $name]);

            $cliente->update([
            'cedula' => request('cedula'),
            'nombre' => request('nombre'),
            'apellidos' => request('apellidos'),
            'celular' => request('celular'),
            'direcion' => request('direcion'),
            'monto_deuda' => request('monto_deuda'),
            'slug_clientes' => request('cedula'),
            'imagencliente' => $name,
            ]);  
            
        }
        $clientes = $cliente::where('cedula',request('cedula'))
        ->first();
        return response()->json(["clientes"=>$clientes],200);
    }

    public function destroy(clientes $cliente)
    {
        if ($cliente->imagencliente == 'usuario.png' ) 
        {
         $cliente->delete();
         return response()->json(["message"=>"Producto eliminado"],200);
        }
        else
        {
         $file_path = public_path().'/imagenes/clientes/'.$cliente->imagencliente;
         \File::delete($file_path);

         $cliente->delete();
         return response()->json(["message"=>"cliente eliminado"],200);
        }
    }
}
