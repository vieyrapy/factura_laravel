<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    public function scopeDate_ini($query, $date_ini) {
    	if ($date_ini != "") {
    		return $query->whereDate('fecha','>=',$date_ini);
    	}
    }

    public function scopeDate_fin($query, $date_fin) {
    	if ($date_fin != "") {
    		return $query->whereDate('fecha','<=',$date_fin);
    	}
    }

    public function scopeMonth_ini($query, $month_ini) {
    	if ($month_ini != "") {
            $datos = explode("-", $month_ini);
    		return $query->whereYear('fecha','>=',$datos[0])->whereMonth('fecha','>=',$datos[1]);
    	}
    }

    public function scopeMonth_fin($query, $month_fin) {
    	if ($month_fin != "") {
            $datos = explode("-", $month_fin);
    		return $query->whereYear('fecha','<=',$datos[0])->whereMonth('fecha','<=',$month_fin);
    	}
    }

    public function scopeYear_ini($query, $year_ini) {
    	if ($year_ini != "") {
    		return $query->whereYear('fecha','>=',$year_ini + 1940);
    	}
    }

    public function scopeYear_fin($query, $year_fin) {
    	if ($year_fin != "") {
    		return $query->whereYear('fecha','<=',$year_fin + 1940);
    	}
    }
}
