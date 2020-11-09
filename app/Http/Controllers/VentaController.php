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

    public function pendientes($id){
        return $this->venta->pendientes($id);
    }
}
