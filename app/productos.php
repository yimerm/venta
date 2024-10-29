<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use App\caregorias;
class productos extends Model
{
	protected $fillable = ['codigo','nombre','categoria','precio_ini','porcentaje','precio_final','cantidades','imagenprod'];
    public $timestamps = false;
    public function getRouteKeyName()
	{
		return 'slug_pro';
	} 
    public function categoria()
	{
		return $this->belongsTo('App\caregorias','categoria');
	}   
	public static function codcategoria()
    {
    	$categoria = caregorias::all()->pluck('nombre','id')->toArray();
        return $categoria;
    }
    public function validateAlpha()
    {
        return is_string($value) && preg_match('/^[\pL\pM]+$/u', $value);
    }
}