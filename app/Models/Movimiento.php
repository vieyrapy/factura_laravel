<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;

class Movimiento extends Model
{
    public $timestamps = false;

	public function categoria(){
        return $this->belongsTo('App\Models\MovimientoCategoria', 'movimiento_categoria_id', 'id');
    }

    public function proveedor(){
        return $this->belongsTo('App\Models\Proveedor', 'proveedor_id', 'id');
    }

	public function scopeDate($query, $date_ini, $date_fin) {
    	if ($date_ini || $date_fin) {
			$format = substr_count($date_ini, "-");
			if($format == 2){
                $query->selectRaw("id, fecha, concepto, proveedor_id, tipo_movimiento, monto");
				if($date_ini){
					$query->whereDate('fecha', '>=', $date_ini);
				}
				if($date_fin){
					$query->whereDate('fecha', '<=', $date_fin);
				}
				return $query->groupBy(["id", "fecha", "movimiento_categoria_id", "concepto", "proveedor_id", "tipo_movimiento", "monto"]);
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
				return $query->groupBy([DB::raw("DATE_FORMAT(fecha,'%m-%Y')"), "movimiento_categoria_id"]);
			} else{
				$query->selectRaw("YEAR(fecha) AS fecha");
				if($date_ini){
					$query->whereYear('fecha', '>= ', $date_ini);
				}
				if($date_fin){
					$query->whereYear('fecha', '<= ', $date_fin);
				}
				return $query->groupBy([DB::raw("YEAR(fecha)"), "movimiento_categoria_id"]);
			}
    	}
    }

    private function filtros($request, $filtros_texto){
        $date_ini = $request->date_ini == "" ? false : $request->date_ini;
        $date_fin = $request->date_fin == "" ? false : $request->date_fin;
        $proveedor = $filtros_texto->proveedor;
        $categoria = $filtros_texto->categoria;
        $concepto = $filtros_texto->concepto;
        $tipo = $filtros_texto->tipo;


        $movimiento = $this->selectRaw("movimiento_categoria_id, SUM(monto) AS monto")
                                ->date($date_ini, $date_fin)
                                ->orderBy('fecha')
                                ->where('eliminado', false)
                                ->paginate(10);

        $pagination = ['pagination' => [
            'total' => $movimiento->total(),
            'current_page' => $movimiento->currentPage(),
            'per_page' => $movimiento->perPage(),
            'last_page' => $movimiento->lastPage(),
            'from' => $movimiento->firstItem(),
            'to' => $movimiento->lastItem()
        ]];
        $movimiento = $movimiento->load(['categoria', 'proveedor']);

        if($proveedor != ""){
            $movimiento = $movimiento->filter(function ($item) use ($proveedor) {
                return false !== stristr($item->proveedor->nombres, $proveedor);
            });
        }

        if($categoria != ""){
            $movimiento = $movimiento->filter(function ($item) use ($categoria) {
                return false !== stristr($item->categoria->nombre, $categoria);
            });
        }

        if($concepto != ""){
            $movimiento = $movimiento->filter(function ($item) use ($concepto) {
                return false !== stristr($item->concepto, $concepto);
            });
        }

        if($tipo != ""){
            $movimiento = $movimiento->filter(function ($item) use ($tipo) {
                return false !== stristr($item->tipo_movimiento, $tipo);
            });
        }

        $pagination["movimientos"] = $movimiento;

        return $pagination;
    }

    public function getMovimientos(Request $request){

        $filtros_texto = json_decode($request->get('movimientos'));
        $request = json_decode($request->get('filters'));
        $movimientos = $this->filtros($request, $filtros_texto);
        return $movimientos;
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
        $movimiento->eliminado = 1;
        $movimiento -> save();
    }

    public function pdf(Request $request){
        $movimiento = $request->get('filtro') > 1 ? $this->filtros($request, null) : $this->filtros($request, null);
        $totales = $this->totales($movimiento);
        $movimiento = $movimiento;
        $filtro = $request->get('filtro');
        $cat_filtro = $request -> get("cat_filtro") != "" ? Categoria::find($request -> get("cat_filtro"))->nombreCategoria : "";
        return ['movimiento' => $movimiento, 'filtros' => $request, 'totales' => $totales, 'filtro' => $filtro, 'cat_filtro' => $cat_filtro];
    }
}
