<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Illuminate\Http\Request;
class ClientesController extends Controller
{

     public function __construct(Clientes $cliente)
    {
        $this->cliente = $cliente;
    }

    public function index(Request $request)
    {
        return $this->cliente->getClientes($request);
    }

    public function create(Request $request)
    {
        return $this->cliente->crearCliente($request);
    }

    public function update(Request $request, $id)
    {
        $this->cliente->editarCliente($request, $id);
    }
}
