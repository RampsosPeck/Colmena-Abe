<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

	protected $table = 'categories';
    protected $fillable = ['nombre','slug','descripcion','imagen','estado'];

    public function productos(){
    	return $this->hasMany(Producto::class);
    }

    public function getImgcateAttribute()
    {
    	if(substr($this->imagen, 0, 4) === "http"){
    		return $this->imagen;
    	}
    	return '/img/categorias/'.$this->imagen;
    }

}
