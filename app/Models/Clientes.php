<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
     // Aqui realizamos la relacion entre cliente
    // Un cliente puede tener muchos pagos
    public function pagos(){
    	return $this->hasMany('App\Models\Pago');
    }



    public function scopeName($query, $name){
    	//dd("scope:".$name);
    	if ($name != ""){
    		$query->where('nombre', "LIKE", "%$name%")
    		 ->orWhere('created_at',  "LIKE", "%$name%")
    		 ->orWhere('email',  "LIKE", "%$name%")
    		 ->orWhere('telefono',  "LIKE", "%$name%")
    		 ->orWhere('id',  "LIKE", "%$name%");
    	}

    }

}
