<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedoresController extends Controller
{
    public function __construct(Proveedor $proveedor)
    {
        $this->proveedor = $proveedor;
    }

    public function index(Request $request)
    {
        return $this->proveedor->getProveedores($request);
    }

    public function store(Request $request)
    {
        return $this->proveedor->crearProveedor($request);
    }

    public function update(Request $request, $id)
    {
        $this->proveedor->editarProveedor($request, $id);
    }
}
