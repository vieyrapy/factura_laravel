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
        $movimiento = $request->get('filtro') ? $this->filtros($request)->get() : $this->filtros($request)->groupBy('id')->get();
        $categoria = Categoria::all();
        $totales = $this->totales($movimiento);
        $filtro = $request->get('filtro') ? $request->get('filtro') : 1;
        return view('movimientos.movimientos', compact('movimiento', 'categoria', 'totales', 'filtro'));
    }

    public function store(Request $request){
        DB::beginTransaction();
        $movimiento = new Movimiento();
        $movimiento->fecha = $request->fecha;
        $movimiento->entidad = $request->nombre;
        $movimiento->categoria_id = $request->categoria;
        $movimiento->concepto = $request->concepto;
        $movimiento->tipo_movimiento = $request->tipo;
        $movimiento->monto = preg_replace('/\D/', '', $request->monto);
        $movimiento->save();
        DB::commit();
        return redirect('movimientos');
    }

    public function pdf(Request $request){
            $movimiento = $request->get('filtro') ? $this->filtros($request)->get() : $this->filtros($request)->groupBy('id')->get();
            $totales = $this->totales($movimiento);
            $filtro = $request->get('filtro');
            $pdf = PDF::loadView('movimientos.reporte', ['movimiento' => $movimiento, 'filtros' => $request, 'totales' => $totales, 'filtro' => $filtro] ); 
            return $pdf->download('reporte.pdf');   
    }

    private function filtros($request){
        $date_ini = $request->get('date_ini');
        $date_fin = $request->get('date_fin');
        $month_ini = $request->get('month_ini');
        $month_fin = $request->get('month_fin');
        $year_ini = $request->get('year_ini');
        $year_fin = $request->get('year_fin');
    
        $movimiento = Movimiento::selectRaw("fecha, entidad, categoria_id, concepto, DATE_FORMAT(fecha,'%M %Y') AS month, YEAR(fecha) AS year,
                                            SUM(CASE WHEN tipo_movimiento = 'ingreso' THEN monto ELSE 0 END) AS ingreso, 
                                            SUM(CASE WHEN tipo_movimiento = 'egreso' THEN monto ELSE 0 END) AS egreso")
                                ->date_ini($date_ini)
                                ->date_fin($date_fin)
                                ->month_ini($month_ini)
                                ->month_fin($month_fin)
                                ->year_ini($year_ini)
                                ->year_fin($year_fin)
                                ->with('categoria')
                                ->orderBy('fecha');

        return $movimiento;
    }

    private function totales($movimiento){
        $total_ingreso = 0;
        $total_egreso = 0;
        foreach($movimiento as $m){
            $total_ingreso += $m -> ingreso;
            $total_egreso += $m -> egreso;
        }

        return [$total_ingreso, $total_egreso];
    }
}
