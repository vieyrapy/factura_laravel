<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Movimiento;
use App\Categoria;
use DB;
use PDF;

class MovimientosController extends Controller
{
    public function index(Request $request){
        
        $movimiento = $this->filtros($request);

        $categoria = Categoria::all();

        return view('movimientos.movimientos', compact('movimiento', 'categoria'));
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

    public function pdf(Request $request){
            $movimiento = $this->filtros($request);
            $pdf = PDF::loadView('movimientos.reporte', ['movimiento' => $movimiento, 'filtros' => $request] ); 
            return $pdf->download('reporte.pdf');   
    }

    private function filtros($request){
        $date_ini = $request->get('date_ini');
        $date_fin = $request->get('date_fin');
        $month_ini = $request->get('month_ini');
        $month_fin = $request->get('month_fin');
        $year_ini = $request->get('year_ini');
        $year_fin = $request->get('year_fin');
    
        $movimiento = Movimiento::date_ini($date_ini)
                                ->date_fin($date_fin)
                                ->month_ini($month_ini)
                                ->month_fin($month_fin)
                                ->year_ini($year_ini)
                                ->year_fin($year_fin)
                                ->with('categoria')
                                ->get();

        return $movimiento;
    }
}
