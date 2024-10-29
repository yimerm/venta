<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Devolucion extends Model
{
    protected $table = "devolucions";
    protected $fillable = ['nfactura','codigo_cliente','codigo_producto','nombre_producto','precio','cantidades','usuario']; 
    protected $primaryKey = 'nfactura';
}
