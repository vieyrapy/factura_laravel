<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth')->group(function () {
    Route::resource('pago', 'PagoController');
    Route::resource('cliente', 'ClientesController');
    Route::resource('categoria', 'CategoriasController');
    Route::resource('categoria-producto', 'CategoriasProductoController');
    Route::resource('producto', 'ProductosController');
    Route::resource('venta', 'VentaController');
    Route::post('mail', 'Email@send');
    Route::get('producto-seleccion', 'CategoriasProductoController@getCategoriasSelect');
});

?>
