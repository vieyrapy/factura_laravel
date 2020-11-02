<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;

class Movimiento extends Model
{

	public function categoria(){
        return $this->belongsTo('App\Models\Categoria');
	}

	public function scopeDate($query, $date_ini, $date_fin) {
    	if ($date_ini || $date_fin) {
			$format = substr_count($date_ini, "-");
			if($format == 2){
				if($date_ini){
					$query->whereDate('fecha', '>=', $date_ini);
				}
				if($date_fin){
					$query->whereDate('fecha', '<=', $date_fin);
				}
				return $query->groupBy(["id", "fecha"]);
			} else if($format == 1){
				$date_ini .= "-01";
				$date_fin .= "-31";
                $query->selectRaw("DATE_FORMAT(fecha,'%m-%Y') AS fecha");
				if($date_ini){
					$query->whereDate('fecha', '>= ', $date_ini);
				}
				if($date_fin){
					$query->whereDate('fecha', '<= ', $date_fin);
				}
				return $query->groupBy([DB::raw("DATE_FORMAT(fecha,'%m-%Y')"), "categoria_id"]);
			} else{
				$query->selectRaw("YEAR(fecha) AS fecha");
				if($date_ini){
					$query->whereYear('fecha', '>= ', $date_ini);
				}
				if($date_fin){
					$query->whereYear('fecha', '<= ', $date_fin);
				}
				return $query->groupBy([DB::raw("YEAR(fecha)"), "categoria_id"]);
			}
    	}
    }

	public function scopeCat_filtro($query, $cat_filtro) {
    	if ($cat_filtro != "") {
			return $query->where('categoria_id','=',$cat_filtro);
    	}
    }

    private function filtros($request){
        $date_ini = $request->date_ini == "" ? false : $request->date_ini;
        $date_fin = $request->date_fin == "" ? false : $request->date_fin;
        $cat_filtro = $request->categoria;


        $movimiento = $this->selectRaw("MAX(id) AS id, MAX(fecha) AS fecha,
                                            MAX(entidad) AS entidad, MAX(categoria_id) AS categoria_id,
                                            MAX(concepto) AS concepto, MAX(monto) AS monto, MAX(tipo_movimiento) AS tipo_movimiento,
                                            SUM(CASE WHEN tipo_movimiento = 'ingreso' THEN monto ELSE 0 END) AS ingreso,
                                            SUM(CASE WHEN tipo_movimiento = 'egreso' THEN monto ELSE 0 END) AS egreso")
                                ->date($date_ini, $date_fin)
                                ->cat_filtro($cat_filtro)
                                ->with('categoria')
                                ->orderBy('fecha');


        return $movimiento;
    }

    private function totales($movimiento){
        $movimiento = $movimiento->get();
        $total_ingreso = 0;
        $total_egreso = 0;
        foreach($movimiento as $m){
            $total_ingreso += $m->ingreso;
            $total_egreso += $m->egreso;
        }

        return ['ingreso' => $total_ingreso, 'egreso' => $total_egreso];
    }

    public function getMovimientos(Request $request){
        $request = json_decode($request->get('filters'));
        $movimientos = $this->filtros($request);
        $totales = $this->totales($movimientos);
        $movimientos = $movimientos->paginate(10);
        return [
            'pagination' => [
                'total' => $movimientos->total(),
                'current_page' => $movimientos->currentPage(),
                'per_page' => $movimientos->perPage(),
                'last_page' => $movimientos->lastPage(),
                'from' => $movimientos->firstItem(),
                'to' => $movimientos->lastItem()
            ],
            'movimientos' => $movimientos,
            'totales' => $totales
        ];
    }

    public function crearMovimiento(Request $request){
        if($request -> id){
            $movimiento = Movimiento::find($request->id);
        } else{
            $movimiento = new Movimiento();
        }
        $movimiento->fecha = $request->fecha;
        $movimiento->entidad = $request->entidad;
        $movimiento->categoria_id = $request->categoria_id;
        $movimiento->concepto = $request->concepto;
        $movimiento->tipo_movimiento = $request->tipo_movimiento;
        $movimiento->monto = preg_replace('/\D/', '', $request->monto);
        $movimiento->save();
    }

    public function eliminarMovimiento($id){
        $movimiento = Movimiento::find($id);
        $movimiento -> delete();
    }

    public function pdf(Request $request){
        $movimiento = $request->get('filtro') > 1 ? $this->filtros($request) : $this->filtros($request)->groupBy(['id']);
        $totales = $this->totales($movimiento);
        $movimiento = $movimiento -> get();
        $filtro = $request->get('filtro');
        $cat_filtro = $request -> get("cat_filtro") != "" ? Categoria::find($request -> get("cat_filtro"))->nombreCategoria : "";
        return ['movimiento' => $movimiento, 'filtros' => $request, 'totales' => $totales, 'filtro' => $filtro, 'cat_filtro' => $cat_filtro];
    }
}
