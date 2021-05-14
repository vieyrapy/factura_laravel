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

use App\Http\Controllers\VentaController;

Auth::routes();
Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/stop', 'StopController@index')->name('stop');

Route::middleware('auth')->group(function () {
    Route::get('/registros', 'PagesController@registros');
//     Route::get('/clientes', function(){ return view('clientes.index');});
//     Route::get('/movimientos', function(){ return view('movimientos.movimientos');});
//     Route::get('/ventas', function(){ return view('ventas.ventas');});
     Route::post('/impresion', 'PdfController@pdf_recibo');
     Route::get('/impresion/{id}', 'VentaController@imprimir');
});
