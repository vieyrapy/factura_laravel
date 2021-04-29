<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    public function __construct(Producto $producto){
        $this->producto = $producto;
    }

    public function index(){
        return $this->producto->getProductos();
    }

    public function store(Request $request){
        $this->producto->crearProducto($request);
    }

    public function update(Request $request, $id){
        $this->producto->editarProducto($request, $id);
    }

    public function getProductosSelect(){
        return $this->producto->getProductosSelect();
    }
}
