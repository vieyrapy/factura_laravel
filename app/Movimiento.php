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
						->groupBy(["id"]);
    	}
    }

    public function scopeDate_fin($query, $date_fin) {
    	if ($date_fin != "") {
			return $query->whereDate('fecha','<=',$date_fin)
						->groupBy(["id"]);
    	}
    }

    public function scopeMonth_ini($query, $month_ini) {
    	if ($month_ini != "") {
            $datos = explode("-", $month_ini);
			return $query->whereYear('fecha','>=',$datos[0])->whereMonth('fecha','>=',$datos[1])
						->groupBy([DB::raw("DATE_FORMAT(fecha,'%M %Y')"), "categoria_id"]);
    	}
    }

    public function scopeMonth_fin($query, $month_fin) {
    	if ($month_fin != "") {
            $datos = explode("-", $month_fin);
			return $query->whereYear('fecha','<=',$datos[0])->whereMonth('fecha','<=',$$datos[1])
						->groupBy([DB::raw("DATE_FORMAT(fecha,'%M %Y')"), "categoria_id"]);
    	}
    }

    public function scopeYear_ini($query, $year_ini) {
    	if ($year_ini != "") {
			return $query->whereYear('fecha','>=',$year_ini + 1940)
						->groupBy([DB::raw("YEAR(fecha)"), "categoria_id"]);
    	}
    }

    public function scopeYear_fin($query, $year_fin) {
    	if ($year_fin != "") {
			return $query->whereYear('fecha','<=',$year_fin + 1940)
						->groupBy([DB::raw("YEAR(fecha)"), "categoria_id"]);
    	}
    }
}
