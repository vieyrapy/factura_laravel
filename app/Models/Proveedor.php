<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Proveedor extends Model
{
    protected $table = "proveedores";

    public function getProveedores(Request $request){
        return Proveedor::all();
    }

    public function crearProveedor(Request $request){
        $proveedor = new Proveedor();
        $proveedor->nombre = $request->nombre;
        $proveedor->ruc = $request->ruc;
        $proveedor->email = $request->email;
        $proveedor->telefono = $request->telefono;
        $proveedor->direccion = $request->direccion;
        $proveedor->save();
        return $proveedor;
    }

    public function editarProveedor(Request $request, $id){
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->nombre = $request->nombre;
        $proveedor->ruc = $request->ruc;
        $proveedor->email = $request->email;
        $proveedor->telefono = $request->telefono;
        $proveedor->direccion = $request->direccion;
        $proveedor->save();
    }
}
