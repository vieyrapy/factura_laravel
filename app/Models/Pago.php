<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Clientes;

class Pago extends Model
{
    // Aqui realizamos la relacion entre cliente
    // Un pago puede tener un cliente
    public function clientes(){
    	return $this->belongsTo('App\Models\Clientes');
    }

    public function getPagos(Request $request){
        $pagos = Pago::whereHas('clientes', function ($query) use ($request){
            $name = $request->get('name');
            $query->where('nombre', "LIKE", "%$name%");
        })->with('clientes')->orderBy('id', 'DESC')->paginate(10);
        return [
            'pagination' => [
                'total' => $pagos->total(),
                'current_page' => $pagos->currentPage(),
                'per_page' => $pagos->perPage(),
                'last_page' => $pagos->lastPage(),
                'from' => $pagos->firstItem(),
                'to' => $pagos->lastItem()
            ],
            'pagos' => $pagos
        ];
    }

    public function crearPago($datos){
        $pago = new Pago;
        $pago->concepto  = $datos->input('concepto');
        $pago->total = $datos->input('total');
        $pago->entrega = $datos->input('entrega');
        $pago->saldo = $datos->input('saldo');
        $pago->clientes_id =  $datos->cliente_id;
        $pago->save();
    }
}
