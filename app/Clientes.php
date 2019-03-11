<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
     // Aqui realizamos la relacion entre cliente 
    // Un cliente puede tener muchos pagos 
    public function pagos(){
    	return $this->hasMany('App\Pago');
    }
}
