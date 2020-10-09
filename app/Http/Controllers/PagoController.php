<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use Illuminate\Http\Request;

class PagoController extends Controller
{

     public function __construct(Pago $pago)
    {
        $this->pago = $pago;
    }

    public function index(Request $request)
    {
        return $this->pago->getPagos($request);
    }

    public function store(Request $request)
    {
        $pago = $this->pago->crearPago($request);
        return $this->pago->getPagoById();
    }
}
