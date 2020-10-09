<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Producto extends Model
{
    public function categoria_producto(){
        return $this->belongsTo('App\Models\CategoriaProducto');
    }

    public function getProductos(){
        $productos = Producto::select(['id', 'nombre', 'descripcion', 'stock_actual', 'stock_minimo', 'precio_venta', 'precio_compra', 'iva', 'categoria_producto_id'])
            ->where('eliminado', '=', 0)
            ->paginate(10);
        return [
            'pagination' => [
                'total' => $productos->total(),
                'current_page' => $productos->currentPage(),
                'per_page' => $productos->perPage(),
                'last_page' => $productos->lastPage(),
                'from' => $productos->firstItem(),
                'to' => $productos->lastItem()
            ],
            'productos' => $productos
        ];
    }

    public function crearProducto(Request $request){
        $producto = new Producto;
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->stock_actual = $request->stock_actual;
        $producto->stock_minimo = $request->stock_minimo;
        $producto->precio_compra = $request->precio_compra;
        $producto->precio_venta = $request->precio_venta;
        $producto->iva = $request->iva;
        $producto->categoria_producto_id = $request->categoria_producto_id;
        $producto->save();
    }

    public function editarProducto(Request $request, $id){
        $producto = Producto::findOrFail($id);
        if($request->nombre){ //Actualiza si llega el nombre
            $producto->nombre = $request->nombre;
            $producto->descripcion = $request->descripcion;
            $producto->stock_actual = $request->stock_actual;
            $producto->stock_minimo = $request->stock_minimo;
            $producto->precio_compra = $request->precio_compra;
            $producto->precio_venta = $request->precio_venta;
            $producto->iva = $request->iva;
            $producto->categoria_producto_id = $request->categoria_producto_id;
        } else{ //Si no hay nombre, reconoce que se quiere marcar como eliminado
            $producto->eliminado = $request->eliminado;
        }
        $producto->save();
    }
}
