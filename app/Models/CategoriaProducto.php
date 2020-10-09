<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CategoriaProducto extends Model
{
    public function getCategorias(){
        return CategoriaProducto::all();
    }

    public function getCategoriasSelect(){
        return Producto::select(['id', 'nombre', 'stock_actual', 'precio_venta', 'iva'])->where('eliminado', '=', 0)->get();
    }

    public function crearCategoria(Request $request){
        $categoria = new CategoriaProducto();
        $categoria->nombre = $request->categoria;
        $categoria->save();
    }
}
