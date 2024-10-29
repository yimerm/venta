<?php

namespace App;

use App\clientes;

use Illuminate\Database\Eloquent\Model;

class venta extends Model
{
    protected $table = "ventas";
    protected $fillable = ['nespera','nfactura','codigo_cliente']; 
    protected $primaryKey = 'codigo_cliente';
    
// usuariocliente select
public static function usuariocliente()
{
    $cliente = clientes::all();
    $select = [];
    foreach($cliente as $cliente)
    {
        $select[$cliente->id] = $cliente->nombre;
    }
    return $select;
} 
//
public function clientes()
	{
		return $this->belongsTo('App\clientes','codigo_cliente')->select(['cedula','nombre','monto_deuda']);
	}

}

