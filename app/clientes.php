<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class clientes extends Model
{
	protected $table = 'clientes';
	protected $fillable = ['cedula','nombre','apellidos','celular','direcion','monto_deuda','imagencliente','slug_clientes'];
    protected $primaryKey = 'cedula';
	public function getRouteKeyName()
	{
		return 'slug_clientes';
	}   
	public function venta()
	{
		return $this->hasMany('App\venta');
	}
}
