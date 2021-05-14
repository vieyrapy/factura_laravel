<?php

use App\Http\Controllers\VentaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth')->group(function () {
    Route::resource('pago-forma', 'PagoFormasController');
    Route::resource('moneda', 'MonedasController');
    Route::resource('pago', 'PagoController');
    Route::resource('cliente', 'ClientesController');
    Route::resource('categoria', 'CategoriasController');
    Route::resource('categoria-producto', 'CategoriasProductoController');
    Route::resource('producto', 'ProductosController');
    Route::resource('venta', 'VentaController');
    Route::resource('movimiento', 'MovimientosController');
    Route::resource('proveedor', 'ProveedoresController');
    Route::post('mail', 'Email@send');
    Route::get('producto-seleccion', 'ProductosController@getProductosSelect');
    Route::post('reporte', 'MovimientosController@pdf');
    Route::get('venta/pendientes/{id}', 'VentaController@pendientes');
    Route::post('caja/apertura', 'CajaController@apertura');
    Route::get('ventas-dia', 'VentaController@totalDia');
});

?>
