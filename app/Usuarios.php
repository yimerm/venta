<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
	protected $fillable = ['usuario','password','login'];
	public function getRouteKeyName()
	{
		return 'slug';
	} 

}
