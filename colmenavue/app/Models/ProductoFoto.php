<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoFoto extends Model
{
    protected $table = 'producto_fotos';
    protected $fillable = ['imagen','favorito','producto_id'];

    public function producto(){
    	return $this->belongsTo(Producto::class);
    }

}
