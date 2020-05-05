<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
use DB;
use Auth;

class CategoriasController extends Controller
{
    public function store(Request $request){
        DB::beginTransaction();
        $categoria = new Categoria();
        $categoria->nombreCategoria = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->save();
        DB::commit();
        return redirect('movimientos');
    }
}
