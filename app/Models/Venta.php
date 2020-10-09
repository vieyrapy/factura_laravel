<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Venta extends Model
{
    public function detalles(){
    	return $this->hasMany('App\Models\DetalleVenta');
    }

    public function cliente(){
    	return $this->belongsTo('App\Models\Clientes');
    }

    public function getVentas(){
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
    }

    public function crearVenta(Request $request){
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
        $formatterES = new \NumberFormatter("es", \NumberFormatter::SPELLOUT);
        $data = array(
            'nombre' => $cliente->nombre,
            'email' => $cliente->email,
            'detalles' => $detalles_venta,
            'total' => $request->total,
            'fecha' => $fecha_venta,
            'condicion' => $request->condicion,
            'ruc' => $cliente->ruc,
            'total_iva' => $request->total_iva,
            'telefono' => $cliente->telefono,
            'direccion' => $cliente->direccion,
            'iva5' => $iva5,
            'iva10' => $iva10,
            'total_letras' => $formatterES->format($request->total)
        );
        return $data;
    }

}
