<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class Email extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('emails.comprobante');
    }

    public function __invoke(Request $request)
    {
        //
    }

    public function send(Request $request){
        $data = $request->all();
        if(isset($data['fecha'])){
            $data['fecha'] = new \DateTime($data['fecha']);
        }
        if(isset($data['clientes'])){
            $cliente = $data['clientes'];
            $email = $cliente['email'];
            $nombre = $cliente['nombre'];
        }else{
            $nombre = $data['nombre'];
            $email = $data['email'];
        }
        $tipo_movimiento = isset($data['detalles']) ? 'venta' : 'emails.comprobante-pago';
        $view = 'emails.comprobante-' . $tipo_movimiento;
        Mail::send($view, $data, function($menssage) use ($email, $nombre, $tipo_movimiento){
            $menssage->from('studiosanchezpy@gmail.com', 'Studio Sánchez');
            $menssage->to($email)->cc('studiosanchezpy@gmail.com')
                    ->subject($nombre.'_Comprobante de '.$tipo_movimiento.'_ID_'.Pago::all()->last()->id);
        });
    }


}
