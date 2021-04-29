<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Moneda extends Model
{
  public $fillable = ['nombre', 'simbolo', 'valor', 'predeterminada'];
    public function getMonedas(){
        return Moneda::all();
    }
}
