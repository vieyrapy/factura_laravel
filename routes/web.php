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

Route::resource('pagos', 'PagoController');
Route::resource('clientes', 'ClientesController');
Route::resource('movimiento', 'MovimientoController');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/comprobante', 'Email@index')->name('comprobante');
Route::get('/clientes/search', 'ClientesController@search')->name('index');

Route::get('/stop', 'StopController@index')->name('stop');
Route::post('/clientes/pdf', 'ClientesController@pdf')->name('pdf');

Route::get('/movimientos', 'MovimientosController@index');


