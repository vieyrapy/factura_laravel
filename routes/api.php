<?php

use Illuminate\Http\Request;
use App\Clientes;
use App\DetalleVenta;
use App\Producto;
use App\Venta;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('clientes', function(Request $request){
    return Clientes::name($request->get('name'))->orderBy('id', 'DESC')->get();
});

Route::post('clientes', function(Request $request){
    $cliente = new Clientes;
    $cliente->nombre = $request->input('nombre');
    $cliente->ruc = $request->input('ruc');
    $cliente->email = $request->input('email');
    $cliente->telefono = $request->input('telefono');
    $cliente->direccion = $request->input('direccion');
    $cliente->save();
    return $cliente;
});

Route::put('clientes/{id}', function(Request $request, $id){
    $cliente = Clientes::findOrFail($id);
    $cliente->nombre = $request->input('nombre');
    $cliente->ruc = $request->input('ruc');
    $cliente->email = $request->input('email');
    $cliente->telefono = $request->input('telefono');
    $cliente->direccion = $request->input('direccion');
    $cliente->save();
});

Route::delete('clientes/{id}', function($id){
    $cliente = Clientes::findOrFail($id);
    $cliente->delete();
});

Route::get('productos', function(){
    return Producto::with('categoria_producto')->get();
});

Route::post('ventas', function(Request $request){
    $venta = new Venta();
    $venta->condicion_venta = $request->condicion;
    $venta->cliente_id = $request->cliente;
    $venta->total = $request->total;
    $venta->total_iva = $request->total_iva;
    $venta->save();
    foreach($request->detalles as $detalle){
        $detalle_venta = new DetalleVenta();
        $detalle_venta->venta_id = Venta::latest('id')->first()->id;
        $detalle_venta->producto_id = $detalle['producto'];
        $detalle_venta->cantidad = $detalle['cantidad'];
        $detalle_venta->valor_venta = $detalle['precio_total'];
        $detalle_venta->save();
        $producto = Producto::find($detalle['producto']);
        $producto->stock_actual -= $detalle['cantidad'];
        $producto->save();
    }
});
