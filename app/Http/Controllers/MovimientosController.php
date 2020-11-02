<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movimiento;
use App\Models\Categoria;
use DB;
use PDF;

class MovimientosController extends Controller
{
    public function __construct(Movimiento $movimiento){
        $this->movimiento = $movimiento;
    }

    public function index(Request $request){
        return $this->movimiento->getMovimientos($request);
    }

    public function store(Request $request){
        $this->movimiento->crearMovimiento($request);
    }

    public function update($id){
        $this->movimiento->eliminarMovimiento($id);
    }

    public function pdf(Request $request){
        $pdf = PDF::loadView('movimientos.reporte', $this->movimiento->pdf($request) );
        return $pdf->download('reporte.pdf',[
            'Content-Type' => 'application/pdf',
        ]);
    }
}
