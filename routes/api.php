<?php

use App\Categoria;
use App\CategoriaProducto;
use Illuminate\Http\Request;
use App\Clientes;
use App\DetalleVenta;
use App\Movimiento;
use App\Pago;
use App\Producto;
use App\Venta;
use Illuminate\Support\Facades\Mail;

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

//APIs relacionadas a clientes
Route::get('clientes', function(Request $request){
    return Clientes::name($request->get('name'))->orderBy('id', 'DESC')->get();
});
Route::post('clientes', function(Request $request){
    $cliente = new Clientes;
    $cliente->nombre = $request->nombre;
    $cliente->ruc = $request->ruc;
    $cliente->email = $request->email;
    $cliente->telefono = $request->telefono;
    $cliente->direccion = $request->direccion;
    $cliente->save();
    return $cliente;
});
Route::put('clientes/{id}', function(Request $request, $id){
    $cliente = Clientes::findOrFail($id);
    $cliente->nombre = $request->nombre;
    $cliente->ruc = $request->ruc;
    $cliente->email = $request->email;
    $cliente->telefono = $request->telefono;
    $cliente->direccion = $request->direccion;
    $cliente->save();
});
Route::delete('clientes/{id}', function($id){
    $cliente = Clientes::findOrFail($id);
    $cliente->delete();
});

//APIs relacionadas a productos
Route::get('categorias/productos', function(){
    return CategoriaProducto::all();
});
Route::get('productos', function(Request $request){
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
});
Route::get('productos/seleccion', function(Request $request){
    return Producto::select(['id', 'nombre', 'stock_actual', 'precio_venta', 'iva'])->where('eliminado', '=', 0)->get();
});
Route::post('productos', function(Request $request){
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
});
Route::put('productos/{id}', function(Request $request, $id){
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
});

//APIs relacionadas a ventas
Route::get('ventas', function(Request $request){
    $ventas = Venta::select(['nro_factura', 'created_at', 'condicion_venta', 'cliente_id', 'total'])
        ->with(['cliente' => function($cliente){
            $cliente->select(['id', 'nombre']);
        }])
        ->paginate(10);
    return [
        'pagination' => [
            'total' => $ventas->total(),
            'current_page' => $ventas->currentPage(),
            'per_page' => $ventas->perPage(),
            'last_page' => $ventas->lastPage(),
            'from' => $ventas->firstItem(),
            'to' => $ventas->lastItem()
        ],
        'ventas' => $ventas
    ];
});
Route::post('ventas', function(Request $request){
    $venta = new Venta();
    $venta->condicion_venta = $request->condicion;
    $venta->cliente_id = $request->cliente;
    $venta->total = $request->total;
    $venta->total_iva = $request->total_iva;
    $venta->save();
    $detalles_venta = [];
    $iva10 = 0;
    $iva5 = 0;
    foreach($request->detalles as $detalle){
        $detalle_venta = new DetalleVenta();
        $detalle_venta->venta_id = $venta->id;
        $detalle_venta->producto_id = $detalle['producto'];
        $detalle_venta->cantidad = $detalle['cantidad'];
        $detalle_venta->valor_venta = $detalle['precio_total'];
        $detalle_venta->save();
        $producto = Producto::find($detalle['producto']);
        $producto->stock_actual -= $detalle['cantidad'];
        $producto->save();
        $detalle_venta->producto = $producto;
        if($producto->iva == 0.04){
            $iva5 += $detalle_venta->valor_venta / 21;
        }else if($producto->iva == 0.09){
            $iva10 += $detalle_venta->valor_venta / 11;
        }
        array_push($detalles_venta, $detalle_venta);
    }

    $fecha_venta = $venta->created_at;
    $cliente = Clientes::find($request->cliente);
    $data = array(
        'nombre' => $cliente->nombre,
        'detalles' => $detalles_venta,
        'total' => $request->total,
        'fecha' => $fecha_venta,
        'condicion' => $request->condicion,
        'ruc' => $cliente->ruc,
        'total_iva' => $request->total_iva,
        'telefono' => $cliente->telefono,
        'direccion' => $cliente->direccion,
        'iva5' => $iva5,
        'iva10' => $iva10
    );
    return $data;
});

Route::post('mail', function(Request $request){
    $data = $request->all();
    $data['fecha'] = new DateTime($data['fecha']);
    Mail::send('emails.comprobante-venta', $data, function($menssage){
        $menssage->from('guillermekleeman@gmail.com', 'Studio Sánchez');
        $menssage->to(Clientes::all()->last()->email)->cc('guillermekleeman@gmail.com')
                ->subject(Clientes::all()->last()->nombre.'_Comprobante de venta_ID_'.Pago::all()->last()->id);
    });
});
?>
