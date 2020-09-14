<?php

namespace App\Http\Controllers;

use App\CategoriaProducto;
use App\Producto;
use Illuminate\Http\Request;
use DB;

class ProductosController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $productos = Producto::with('categoria_producto')->get();
        $categorias = CategoriaProducto::all();
        return view('productos.productos', ['productos' => $productos, 'categorias' => $categorias]);
    }

    public function store(Request $request){
        DB::beginTransaction();
        if($request -> id){
            $producto = Producto::find($request->id);
        } else{
            $producto = new Producto();
        }
        $producto->nombre = $request->producto;
        $producto->descripcion = $request->descripcion;
        $producto->categoria_producto_id = $request->categoria;
        $producto->iva = $request->iva;
        $producto->stock_actual = $request->stock_actual;
        $producto->stock_minimo = $request->stock_minimo;
        $producto->precio_venta = preg_replace('/\D/', '', $request->precio_venta);
        $producto->precio_compra = preg_replace('/\D/', '', $request->precio_compra);
        $producto->save();
        DB::commit();
        return redirect('productos');
    }

    public function destroy($id){
        $producto = Producto::find($id);
        $producto -> delete();
        return redirect('productos');
    }
}
