<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    // Aqui realizamos la relacion entre cliente 
    // Un pago puede tener un cliente 
    public function cliente(){
    	return $this->belongsTo('App\Clientes');
    }
}
