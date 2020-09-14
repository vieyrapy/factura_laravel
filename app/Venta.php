<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    public function detalles(){
    	return $this->hasMany('App\DetalleVenta');
    }

    public function cliente(){
    	return $this->belongsTo('App\Clientes');
    }
}
