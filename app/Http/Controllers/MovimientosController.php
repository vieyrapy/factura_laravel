<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movimiento;

class MovimientosController extends Controller
{
    public function index(){
        $movimiento = Movimiento::
                        join('categorias', 'categorias.id', '=', 'movimientos.categoria_id')
                        ->select('movimientos.fecha', 'movimientos.entidad', 'categorias.nombreCategoria',
                        'movimientos.concepto', 'movimientos.monto', 'movimientos.tipo_movimiento')
                        ->get();;
        return view('movimientos.movimientos', compact('movimiento'));
    }
}
