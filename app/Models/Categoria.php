<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Categoria extends Model
{
    public function crearCategoria(Request $request){
        $categoria = new Categoria();
        $categoria->nombreCategoria = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->save();
    }

    public function getCategorias(){
        return Categoria::all();
    }
}
