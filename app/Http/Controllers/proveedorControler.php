<?php

namespace App\Http\Controllers;
use App\proveedor;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProveedorRequest;
class proveedorControler extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 
        if ($request->ajax()){
            $proveedore = proveedor::paginate(5);
            $data = ["proveedore"=> $proveedore]; 
            return response()->json($data,200);
        }
        return view('proveedor.index',compact('proveedor'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProveedorRequest $request)
    {
        if ($request->ajax()) 
        {
            $validateData = $request->validate(['nombre'=> 'unique:proveedors']);
            $proveedor = new proveedor();
            $proveedor->nombre = $request->input('nombre');
            $proveedor->celular = $request->input('celular');
            $proveedor->surtidor = $request->input('surtidor'); 
            $proveedor->slug_proveedor = $request->input('nombre').$request->input('surtidor');
            $proveedor->save(); 
            return response()->json([
                "message"=>"proveedor creado",
                "proveedor"=>$proveedor
            ],200);
         }
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
    public function edit(proveedor $proveedor)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProveedorRequest $request, proveedor $proveedor)
    { 
        $proveedor->update([
        'nombre' => request('nombre'),
        'celular' => request('celular'),
        'surtidor' => request('surtidor'),
        'slug_proveedor' => request('nombre'),
        ]);
        $data = ["proveedor" =>$proveedor]; 
            return response()->json($data,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(proveedor $proveedor)
    {
        $proveedor->delete();
         return response()->json(["message"=>"proveedor eliminado"],200); 
    }
}
 