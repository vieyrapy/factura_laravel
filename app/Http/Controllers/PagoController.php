<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Clientes;
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

    public function create()
    {

    }

    public function store(Request $request)
    {
          $this->pago->crearPago($request);
    }

    public function show(Pago $pago)
    {

    }

    public function edit(Pago $pago)
    {

    }

    public function update(Request $request, Pago $pago)
    {

    }

    public function destroy(Pago $pago)
    {

    }
}
