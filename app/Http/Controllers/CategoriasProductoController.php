<?php

namespace App\Http\Controllers;

use App\Models\CategoriaProducto;
use Illuminate\Http\Request;
use DB;

class CategoriasProductoController extends Controller
{
    public function __construct(CategoriaProducto $categoria)
    {
        $this->categoria = $categoria;
    }

    public function index()
    {
        return $this->categoria->getCategorias();
    }

    public function store(Request $request)
    {
        $this->categoria->crearCategoria($request);
    }

    public function getCategoriasSelect(){
        return $this->categoria->getCategoriasSelect();
    }
}
