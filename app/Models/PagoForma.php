<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PagoForma extends Model
{
    public function getPagoFormas(){
        return PagoForma::all();
    }
}
