<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use Illuminate\Http\Request;

class CajaController extends Controller
{
    public function apertura(Request $request){
        return Caja::apertura($request->monto);
    }
}
