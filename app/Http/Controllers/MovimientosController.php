<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MovimientosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
}
