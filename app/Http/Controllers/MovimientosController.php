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
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request){
        $movimiento = $request->get('filtro') > 0 ? $this->filtros($request)->get() : $this->filtros($request)->groupBy(['id'])->get();
        $categoria = Categoria::all();
        $totales = $this->totales($movimiento);
        $filtro = $request->get('filtro');
        return view('movimientos.movimientos', compact('movimiento', 'categoria', 'totales', 'filtro'));
    }

    public function store(Request $request){
        DB::beginTransaction();
        if($request -> id){
            $movimiento = Movimiento::find($request->id);
        } else{
            $movimiento = new Movimiento();
        }
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

    public function destroy($id){
        $movimiento = Movimiento::find($id);
        $movimiento -> delete();
        return redirect('movimientos');
    }

    public function pdf(Request $request){
            $movimiento = $request->get('filtro') > 0 ? $this->filtros($request)->get() : $this->filtros($request)->groupBy(['id'])->get();
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
        $cat_filtro = $request->get('cat_filtro');
    
        $movimiento = Movimiento::selectRaw("MAX(id) AS id, MAX(fecha) AS fecha, 
                                            MAX(entidad) AS entidad, MAX(categoria_id) AS categoria_id, 
                                            MAX(concepto) AS concepto, MAX(monto) AS monto, MAX(tipo_movimiento) AS tipo_movimiento,
                                            SUM(CASE WHEN tipo_movimiento = 'ingreso' THEN monto ELSE 0 END) AS ingreso, 
                                            SUM(CASE WHEN tipo_movimiento = 'egreso' THEN monto ELSE 0 END) AS egreso")
                                ->date_ini($date_ini)
                                ->date_fin($date_fin)
                                ->month_ini($month_ini)
                                ->month_fin($month_fin, $month_ini)
                                ->year_ini($year_ini)
                                ->year_fin($year_fin, $year_ini)
                                ->cat_filtro($cat_filtro)
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