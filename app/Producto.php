<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    public function categoria_producto(){
        return $this->belongsTo('App\CategoriaProducto');
	}
}
