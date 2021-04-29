<?php

namespace App\Http\Controllers;

use App\Models\Moneda;
use Illuminate\Http\Request;

class MonedasController extends Controller
{
    public function __construct(Moneda $moneda)
    {
        $this->moneda = $moneda;
    }

    public function index()
    {
        return $this->moneda->getMonedas();
    }
}
