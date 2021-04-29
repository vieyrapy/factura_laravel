<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Clientes extends Model
{

    public $table = 'clientes';
     // Aqui realizamos la relacion entre cliente
    // Un cliente puede tener muchos pagos
    public function pagos(){
    	return $this->hasMany('App\Models\Pago');
    }

    public function scopeName($query, $name){
    	//dd("scope:".$name);
    	if ($name != ""){
    		$query->where('nombre', "LIKE", "%$name%")
    		 ->orWhere('created_at',  "LIKE", "%$name%")
    		 ->orWhere('email',  "LIKE", "%$name%")
    		 ->orWhere('telefono',  "LIKE", "%$name%")
    		 ->orWhere('id',  "LIKE", "%$name%");
    	}
    }

    public function getClientes(Request $request){
        return Clientes::name($request->get('name'))->orderBy('id', 'DESC')->get();
    }

    public function crearCliente(Request $request){
        $cliente = new Clientes();
        $cliente->nombre = $request->nombre;
        $cliente->ruc = $request->ruc;
        $cliente->email = $request->email;
        $cliente->telefono = $request->telefono;
        $cliente->direccion = $request->direccion;
        $cliente->save();
        return $cliente;
    }

    public function editarCliente(Request $request, $id){
        $cliente = Clientes::findOrFail($id);
        $cliente->nombre = $request->nombre;
        $cliente->ruc = $request->ruc;
        $cliente->email = $request->email;
        $cliente->telefono = $request->telefono;
        $cliente->direccion = $request->direccion;
        $cliente->save();
    }
}
