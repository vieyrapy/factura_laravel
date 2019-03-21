<?php

namespace App\Http\Controllers;
 
use App\Clientes;
use App\Pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ClientesController extends Controller 
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //dd($request->get('name'));//probaar request 

        // Creamos una variable en este caso $cliente y le pedimos que traiga todos los clientes de la BD 
        // Laravel utiliza ORM = Object Relational Mapping
        //$cliente = Clientes::all();//trae todos los clientes

        $cliente = Clientes::name($request->get('name'))->orderBy('id', 'DESC')->paginate(10);//trae todos los clientes
        // Var dump es una excelente función para comprobar si definitavamente la consulta debuelve algo de la base de datos 
        //var_dump($cliente);


        // es igual a clientes/index y pedimos que devuelva todos los clientes en index (nombre_tabla, variablecreada)
        return view('clientes.index')->with('clientes', $cliente); 

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    
          //Crear un nuevo cliente en nuestra base de datos
          $cliente = new Clientes;
          $cliente->nombre = $request->input('nombre');  
          $cliente->email = $request->input('email');
          $cliente->telefono = $request->input('telefono');
          $cliente->save();

          //Se obtiene el ultimo id del cliente guardado 
        $cliente_id = Clientes::all()->last()->id;
       

          $pago = new Pago;
          $pago-> concepto  = $request->input('concepto');
          $pago-> total = $request->input('total');
          $pago-> entrega = $request->input('entrega');
          $pago-> saldo = $request->input('saldo');
          $pago-> clientes_id =  $cliente_id;
          $pago->save();


       
        // Se obtiene el correo electronico 
        //$email_last = Clientes::all()->last()->email;


          // se realiza un array de los datos guaradados para enviara por email 
          $fecha_recibo = Pago::all()->last()->created_at;
          $data = array(
            
           'nombre' => $request->input('nombre'),
           'concepto' => $request->input('concepto'),
           'total' => $request->input('total'),
           'entrega' => $request->input('entrega'),
            'saldo' => $request->input('saldo'), 
            'fecha' => $fecha_recibo


          );
                Mail::send('emails.comprobante', $data, function($menssage){
                $menssage->from('vieyrasite@hotmail.com', 'Studio Sánchez');
                $menssage->to(Clientes::all()->last()->email)->subject('Comprobante de pago');
            }); 

          //realizar un mensaje de guardado 
            return "Tu email ha sido enviado";
          //return redirect('../inc/mensajes')->with('success', 'Cliente guardado');

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Mostrar detalles de un cliente
        //$cliente_nombre = Pago::with('cliente')->get();

        //
        $pago = Pago::find($id);     
        return view('clientes.detalles')->with('pagos', $pago); 

      
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function edit(Clientes $clientes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Clientes $clientes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Clientes $clientes)
    {
        //
    }
}
