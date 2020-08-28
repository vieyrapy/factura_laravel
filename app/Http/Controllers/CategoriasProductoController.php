<?php

namespace App\Http\Controllers;

use App\CategoriaProducto;
use Illuminate\Http\Request;
use DB;

class CategoriasProductoController extends Controller
{
    public function store(Request $request){
        DB::beginTransaction();
        if($request -> id){
            $categoria = CategoriaProducto::find($request->id);
        } else{
            $categoria = new CategoriaProducto();
        }
        $categoria->nombre = $request->nombre;
        $categoria->save();
        DB::commit();
        return redirect('productos');
    }
}
