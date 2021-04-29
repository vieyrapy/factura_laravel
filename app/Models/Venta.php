<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;
use Auth;

class Venta extends Model
{
    public $timestamps = false;
    public function detalles(){
    	return $this->hasMany('App\Models\DetalleVenta');
    }

    public function cliente(){
    	return $this->belongsTo('App\Models\Clientes');
    }

    public function forma_pago(){
    	return $this->belongsTo('App\Models\PagoForma', 'pago_forma_id', 'id');
    }

    public function scopeDate($query, $date_ini, $date_fin) {
    	if ($date_ini || $date_fin) {
			$format = substr_count($date_ini, "-");
			if($format == 2){
                $query->selectRaw("ventas.id, fecha, factura_numero, cliente_id, clientes.nombres AS cliente")
                        ->join('clientes', 'cliente_id', '=', 'clientes.id');
				if($date_ini){
					$query->whereDate('fecha', '>=', $date_ini);
				}
				if($date_fin){
					$query->whereDate('fecha', '<=', $date_fin);
				}
				return $query->groupBy(["ventas.id", "fecha", "factura_numero", "pago_forma_id", "cliente_id", "clientes.nombres", "total", "pago_forma_id", "forma_pago"]);
			} else if($format == 1){
				$date_ini .= "-01";
				$date_fin .= "-31";
                $query->selectRaw("DATE_FORMAT(fecha,'%m-%Y') AS fecha");
				if($date_ini){
					$query->whereDate('fecha', '>= ', $date_ini);
				}
				if($date_fin){
					$query->whereDate('fecha', '<= ', $date_fin);
				}
				return $query->groupBy([DB::raw("DATE_FORMAT(fecha,'%m-%Y')"), "pago_forma_id", "forma_pago"]);
			} else{
				$query->selectRaw("YEAR(fecha) AS fecha");
				if($date_ini){
					$query->whereYear('fecha', '>= ', $date_ini);
				}
				if($date_fin){
					$query->whereYear('fecha', '<= ', $date_fin);
				}
				return $query->groupBy([DB::raw("YEAR(fecha)"), "pago_forma_id", "forma_pago"]);
			}
    	}
    }

    public function filtros($request = null, $filtros_texto = null, $apertura = false){
        $date_ini = !isset($request) ? date('Y-m-d') : $request->date_ini;
        $date_fin = !isset($request) ? date('Y-m-d') : $request->date_fin;

        if($filtros_texto){
            $numero_factura = $filtros_texto->numero_factura;
            $cliente = $filtros_texto->cliente;
            $pago = $filtros_texto->pago;
        }else{
            $numero_factura = "";
            $cliente = "";
            $pago = "";
        }

        $venta = $this->selectRaw("pago_forma_id, forma_pago, SUM(total) AS monto")
                                ->date($date_ini, $date_fin)
                                ->orderBy('fecha')
                                ->where('ventas.eliminado', false)
                                ->join('pago_formas', 'pago_forma_id', '=', 'pago_formas.id');

        if($numero_factura != ""){
            $venta = $venta->where('factura_numero', 'like', '%'.$numero_factura.'%');
        }

        if($cliente != ""){
            $venta = $venta->where('cliente', 'like', '%'.$cliente.'%');
        }

        if($pago != ""){
            $venta = $venta->where('forma_pago', 'like', '%'.$pago.'%');
        }

        if($apertura != "false"){
            $caja = Caja::selectRaw("1 AS pago_forma_id, 'Efectivo' AS forma_pago, monto_apertura AS monto, 0 AS id, fecha, '-' AS factura_numero, 1 AS cliente_id, 'Apertura' AS cliente")->whereDate('fecha', date('Y-m-d'));
            $query = $venta->union($caja);
            $querySql = $query->toSql();
            $venta = DB::table(DB::raw("($querySql) AS a"))->mergeBindings($query->getQuery());
        }
            return $venta;
    }

    public function getVentas(Request $request){

        $filtros_texto = json_decode($request->get('ventas'));
        $apertura = $request->get('apertura');
        $request = json_decode($request->get('filters'));
        $ventas = $this->filtros($request, $filtros_texto, $apertura);
        $ventas = $ventas->paginate(10);
        $pagination = ['pagination' => [
                        'total' => $ventas->total(),
                        'current_page' => $ventas->currentPage(),
                        'per_page' => $ventas->perPage(),
                        'last_page' => $ventas->lastPage(),
                        'from' => $ventas->firstItem(),
                        'to' => $ventas->lastItem()
                        ]];

        $pagination["ventas"] = $ventas;
        return $pagination;
    }

    public function eliminarVenta($id){
        $venta = Venta::find($id);
        $venta->eliminado = 1;
        $venta -> save();
    }

    public function crearVenta(Request $request){
        $venta = new Venta();
        $venta->factura_numero = isset($request->factura) ? $request->factura : "";
        $venta->condicion = $request->pago_forma == 2 ? 2 : 1;
        $venta->cliente_id = $request->cliente;
        $venta->total = $request->total;
        $venta->total_iva = $request->total_iva;
        $venta->monto_pendiente = $request->total - $request->pago;
        $venta->numero_transaccion = $request->numero_transaccion;
        $venta->operadora = $request->operadora;
        $venta->pago_forma_id = $request->pago_forma;
        $venta->usuario_id = Auth::user()->id;
        $venta->fecha = date('Y-m-d');
        $venta->save();
        $detalles_venta = [];
        $iva5 = 0;
        $iva10 = 0;
        foreach($request->detalles as $detalle){
            $detalle_venta = new DetalleVenta();
            $detalle_venta->venta_id = $venta->id;
            $detalle_venta->productos_id = $detalle['producto'];
            $detalle_venta->cantidad = $detalle['cantidad'];
            $detalle_venta->valor_guaranies = $detalle['precio_total'];
            switch($request->moneda->id){
              case 2: $detalle_venta->total_dolares = $request->total_moneda; break;
              case 3: $detalle_venta->total_reales = $request->total_moneda; break;
              case 4: $detalle_venta->total_pesos = $request->total_moneda; break;
            }
            $detalle_venta->save();
            $producto = Producto::find($detalle['producto']);
            $producto->stock_actual -= $detalle['cantidad'];
            $producto->save();
            $categoria_iva = CategoriaProducto::find($producto->producto_categoria_id)->iva;
            $detalle_venta->producto = $producto;
            $detalle_venta->iva = $categoria_iva;
            if($categoria_iva == 5){
                $iva5 += $detalle_venta->iva_total;
            }else if($categoria_iva == 10){
                $iva10 += $detalle_venta->iva_total;
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
            'condicion' => $venta->condicion,
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

    public function pendientes($id){
        return Venta::where([
            ['monto_pendiente', '>', '0'],
            ['cliente_id', '=', $id]
        ])->get();
    }

}
