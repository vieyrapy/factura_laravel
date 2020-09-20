<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    public function categoria_producto(){
        return $this->belongsTo('App\Models\CategoriaProducto');
	}
}
