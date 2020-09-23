<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::resource('clientes', 'ClientesController');
Route::resource('movimiento', 'MovimientosController');
Route::resource('categoria', 'CategoriasController');
Route::resource('categorias_producto', 'CategoriasProductoController');
Route::resource('productos', 'ProductosController');
Auth::routes();

Route::get('/clientes', function(){
    return view('clientes.index');
})->middleware('auth');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/comprobante', 'Email@index')->name('comprobante');
Route::get('/clientes/search', 'ClientesController@search')->name('index');

Route::get('/stop', 'StopController@index')->name('stop');
Route::post('/clientes/pdf', 'ClientesController@pdf')->name('pdf');
Route::post('/movimientos/pdf', 'MovimientosController@pdf')->name('reporte');

Route::get('/movimientos', 'MovimientosController@index');
Route::delete('movimientos/{id}', 'MovimientosController@destroy')->name('movimientos.destroy');

Route::get('/productos', 'ProductosController@index');
Route::delete('productos/{id}', 'ProductosController@destroy')->name('productos.destroy');

Route::get('/ventas', function(){
    return view('ventas.ventas');
})->middleware('auth');

Route::post('/impresion', 'PdfController@pdf_recibo');
