<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class caregorias extends Model
{
    	protected $fillable = ['nombre'];

    	public function getRouteKeyName()
	{
		return 'slug_categoria';
	} 


	    public function productos()
	{
		return $this->hasMany('App\productos');
	} 
}
