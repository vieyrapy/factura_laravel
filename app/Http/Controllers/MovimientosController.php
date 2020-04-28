<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Movimiento;
use DB;

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

    public function store(Request $request){
        DB::beginTransaction();
        $movimiento = new Movimiento();
        $movimiento->fecha = $request->fecha;
        $movimiento->entidad = $request->nombre;
        $movimiento->categoria_id = $request->categoria;
        $movimiento->concepto = $request->concepto;
        $movimiento->tipo_movimiento = $request->tipo;
        $movimiento->monto = $request->monto;
        $movimiento->save();
        DB::commit();
        return redirect('movimientos');
    }
}
