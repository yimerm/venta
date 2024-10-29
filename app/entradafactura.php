<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\proveedor;
use App\inventarioproducto;

class entradafactura extends Model
{
    protected $table = "entradafacturas";
    protected $fillable = ['proveedor','pago','fecha_pago'];
    protected $primaryKey = 'codigo';
    //public $incrementing = false;
    protected $keyType = 'string';

	public function proveedor()
	{
		return $this->belongsTo('App\proveedor','proveedor');
	} 
    public function inventarioproducto()
    { 
        return $this->hasMany('App\inventarioproducto','codigo_factura','codigo')
        ->selectRaw('codigo_factura,sum(precio_ini * cantidades) as total')
        ->groupBy('codigo_factura');
        
    } 
	public static function codprove()
    {
    	$proveedores = proveedor::all();
        $select = [];
        foreach($proveedores as $proveedores)
        {
            $select[$proveedores->id] = $proveedores->nombre;
        }
        return $select;
    } 
  
}
