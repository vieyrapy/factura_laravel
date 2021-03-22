<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\Venta;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function registros(){
        $apertura = !isset(Caja::all()->last()->monto_apertura) || !is_null(Caja::all()->last()->monto_total);
        $total = (new Venta())->filtros()->get()->sum('monto');
        return view('registros', compact(['apertura', 'total']));
    }
}
