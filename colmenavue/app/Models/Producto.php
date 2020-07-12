<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
	protected $table = 'productos';
    protected $fillable = [
    	'nombre',
    	'slug',
    	'codigo',
    	'descripcion',
    	'descuento',
    	'precio',
    	'stock',
    	'cant_personas',
    	'oferta',
    	'estado',
    	'category_id'];

    public function categoria(){
    	return $this->belongsTo(Categoria::class);
    }

    public function fotos(){
        return $this->hasMany(ProductoFoto::class);
    }

    //Accesor para imagen por defecto
    public function getImgproductoUrlAttribute()
    {
        $imgUno = $this->fotos()->first();

        if($imgUno){
            return $imgUno->imagen;//del otro mutator que hicimos en el modelo ProductImage
        }
        return '/img/productos/default.jpg';
    }


    //Accesor para imagen favorito
    public function getImgProFavoritoAttribute()
    {
        $imgFavorito = $this->fotos()->where('favorito',true)->first();

        if(!$imgFavorito){ //En caso que la imagen no sea destacada
            $imgFavorito = $this->fotos()->first();
        }
        if($imgFavorito){
            return $imgFavorito->url;//del otro mutator que hicimos en el modelo ProductImage
        }
        return '/img/default.jpg';
    }

    public function prodetalles()
    {
        return $this->belongsToMany(Prodetalle::class);
    }

}
