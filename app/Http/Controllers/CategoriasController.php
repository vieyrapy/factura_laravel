<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriasController extends Controller
{

    public function __construct(Categoria $categoria)
    {
        $this->categoria = $categoria;
    }

    public function store(Request $request){
        $this->categoria->crearCategoria($request);
        return redirect('movimientos');
    }
}
