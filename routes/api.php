<?php

use Illuminate\Http\Request;
use App\Clientes;

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
    return Clientes::name($request->get('name'))->orderBy('id', 'DESC')->paginate(10);
});

Route::post('clientes', function(Request $request){
    $cliente = new Clientes;
    $cliente->nombre = $request->input('nombre');
    $cliente->ruc = $request->input('ruc');
    $cliente->email = $request->input('email');
    $cliente->telefono = $request->input('telefono');
    $cliente->direccion = $request->input('direccion');
    $cliente->save();
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
