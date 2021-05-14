<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;

class VentaController extends Controller
{

     public function __construct(Venta $venta)
    {
        $this->venta = $venta;
    }

    public function index(Request $request)
    {
        return $this->venta->getVentas($request);
    }

    public function store(Request $request)
    {
        return $this->venta->crearVenta($request);
    }

    public function update($id){
        $this->venta->eliminarVenta($id);
    }

    public function pendientes($id){
        return $this->venta->pendientes($id);
    }

    public function imprimir($id){
        return $this->venta->imprimir($id);
    }

    public function totalDia(){
        return (new Venta())->filtros()->get()->sum('monto');
    }
}
