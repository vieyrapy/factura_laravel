<?php

namespace App\Http\Controllers;

use App\Models\PagoForma;
use Illuminate\Http\Request;

class PagoFormasController extends Controller
{
    public function __construct(PagoForma $pago_forma)
    {
        $this->pago_forma = $pago_forma;
    }

    public function index()
    {
        return $this->pago_forma->getPagoFormas();
    }
}
