<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Movimiento extends Model
{

	public function categoria(){
        return $this->belongsTo('App\Categoria');
	}
	
	public function scopeDate($query, $date_ini, $date_fin) {
    	if ($date_ini || $date_fin) {
			$format = substr_count($date_ini, "-");
			if($format == 2){
				if($date_ini){
					$query->whereDate('fecha','>=',$date_ini);
				}
				if($date_fin){
					$query->whereDate('fecha', '<=', $date_fin);
				}
				return $query->groupBy(["id", "fecha"]);
			} else if($format == 1){
				$datos_ini = explode("-", $date_ini);
				$datos_fin = explode("-", $date_fin);
				$query->selectRaw("DATE_FORMAT(fecha,'%m-%Y') AS fecha");
				if($date_ini){
					$query->whereYear('fecha', '>= ', $datos_ini[0])->whereMonth('fecha', '>= ', $datos_ini[1]);
				}
				if($date_fin){
					$query->whereYear('fecha', '<= ', $datos_fin[0])->whereMonth('fecha', '<= ', $datos_fin[1]);
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
}