<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Movimiento extends Model
{

	public function categoria(){
        return $this->belongsTo('App\Categoria');
	}
	
    public function scopeDate_ini($query, $date_ini) {
    	if ($date_ini != "") {
			return $query->whereDate('fecha','>=',$date_ini)
						->groupBy(["id", "fecha"]);
    	}
    }

    public function scopeDate_fin($query, $date_fin) {
    	if ($date_fin != "") {
			return $query->whereDate('fecha','<=',$date_fin)
						->groupBy(["id", "fecha"]);
    	}
    }

    public function scopeMonth_ini($query, $month_ini) {
    	if ($month_ini != "") {
            $datos = explode("-", $month_ini);
			return $query->selectRaw("DATE_FORMAT(fecha,'%M %Y') AS month")
						->whereYear('fecha', '>= ', $datos[0])->whereMonth('fecha', '>= ', $datos[1])
						->groupBy(["month", "categoria_id"]);
    	}
    }

    public function scopeMonth_fin($query, $month_fin, $month_ini) {
    	if ($month_fin != "") {
            $datos = explode("-", $month_fin);
			$query->whereYear('fecha','<=',$datos[0])->whereMonth('fecha','<=',$datos[1]);
			if($month_ini == ""){
				$query->selectRaw("DATE_FORMAT(fecha,'%M %Y') AS month")
						->groupBy(["month", "categoria_id"]);
			}
			return $query;
    	}
    }

    public function scopeYear_ini($query, $year_ini) {
    	if ($year_ini != "") {
			return $query->selectRaw("YEAR(fecha) AS year")
						->whereYear('fecha', '>= ', date("Y") + $year_ini)
						->groupBy(["year", "categoria_id"]);
    	}
    }

    public function scopeYear_fin($query, $year_fin, $year_ini) {
    	if ($year_fin != "") {
			$query->whereYear('fecha', '<=', date("Y") + $year_fin);
			if($year_ini == ""){
				$query->selectRaw("YEAR(fecha) AS year")
						->groupBy(["year", "categoria_id"]);
			}
    	}
	}
	
	public function scopeCat_filtro($query, $cat_filtro) {
    	if ($cat_filtro > 0) {
			return $query->where('categoria_id','=',$cat_filtro);
    	}
    }
}