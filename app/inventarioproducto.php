<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class inventarioproducto extends Model
{
    protected $fillable = ['codigo_factura','codigo_producto','nombre_producto','precio_ini','porcentaje','precio_final','cantidades','promocion'];
    protected $primaryKey = 'id';
    //public $incrementing = false;
    protected $keyType = 'string';

    public function inventarioproducto()
	{
		return $this->belongsTo('App\entradafactura','codigo_factura');
	} 
 
 	/*public static function totarfactura()
    {
    	$totarfactura = inventarioproducto::where('codigo_factura', '=', 'codigo')
    	->selectRaw('sum(precio_ini * cantidades) as total' );
 
    }
 */
  
}
