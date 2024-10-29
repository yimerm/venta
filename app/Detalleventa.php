<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Detalleventa extends Model
{
    protected $table = "detalleventas";
    protected $fillable = ['id_ventas','codigo','nombre','precio','cantidad'];
    protected $primaryKey = 'id_ventas';

}
