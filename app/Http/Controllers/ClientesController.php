<?php

namespace App\Http\Controllers;
 
use App\Clientes;
use App\Pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PDF;
use DB;
class ClientesController extends Controller 
{

     public function __construct()
    {
        $this->middleware('auth');
    }
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
        //Transaccion y Rollback
        DB::beginTransaction();
        try{
    
                  //Crear un nuevo cliente en nuestra base de datos
                  $cliente = new Clientes;
                  $cliente->nombre = $request->input('nombre');  
                  $cliente->email = $request->input('email');
                  $cliente->telefono = $request->input('telefono');
                  $cliente->save();

                  //Se obtiene el ultimo id del cliente guardado para pasarle ese dato a clientes_id
                    $cliente_id = Clientes::all()->last()->id;
               

                  $pago = new Pago;
                  $pago-> concepto  = $request->input('concepto');
                  $pago-> total = preg_replace('/\D/', '', $request->input('total'));
                  $pago-> entrega = preg_replace('/\D/', '', $request->input('entrega'));
                  $pago-> saldo = preg_replace('/\D/', '', $request->input('saldo'));
                  $pago-> clientes_id =  $cliente_id;
                  $pago->save();
                  

                DB::commit();

            } catch(\Exception $e){

                //si hay un error / excepción en el código anterior antes de confirmar, se revertirá los datos en la BD
                // pero el EMAIL IGUAL SERÁ ENVIADO

                DB::rollBack();
                    return 'EL EMAIL FUE ENVIADO pero se ha detectado un error y no se pudo guardar los cambios en la Base de Datos. Verifique su conexión a internet o consulte con el Administrador de Sistemas';
                }



        try{        
                // Se obtiene el correo electronico 
                //$email_last = Clientes::all()->last()->email; 

            
              // se realiza un array de los datos guaradados para enviara por email 
              $fecha_recibo = Pago::all()->last()->created_at;
              $data = array(
                // preg_replace('/\D/', '', ) se utiliza para retirar caracteres de un lista recibe tres datos el valor a quitar '/\D/' el valor nuevo "" y cual es valor que debemos analizar y hacer los cambios 

               'nombre' => $request->input('nombre'),
               'concepto' => $request->input('concepto'),
               'total' => preg_replace('/\D/', '', $request->input('total')),
               'entrega' => preg_replace('/\D/', '', $request->input('entrega')),
                'saldo' => preg_replace('/\D/', '', $request->input('saldo')), 
                'fecha' => $fecha_recibo
                );

                    
                    Mail::send('emails.comprobante', $data, function($menssage){

                    $menssage->from('recibos@studiosanchez.rocemi.com.py', 'Studio Sánchez');
                    $menssage->to(Clientes::all()->last()->email)->cc('studiosanchezpy@gmail.com')->subject(Clientes::all()->last()->nombre.'_Comprobante de pago');
                    }); 
            
                    Mail::failures();
                    
            } catch(\Exception $e){

                //si hay un error / excepción en el código anterior antes de confirmar, se revertirá los datos en la BD
                // pero el EMAIL IGUAL SERÁ ENVIADO

                    return 'No se pudo enviar el email';
                }

            try{  

                  //redirige a la pagina index de cliente
                    return redirect()->route('clientes.index');

             } catch(\Exception $e){

                //Redirige a inicio

                    return view('welcome');
                }
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
        $cliente_id = Pago::find($id)->clientes_id;
        $cliente = Clientes::find($cliente_id);
        $pago = Pago::find($id);     

        return view('clientes.detalles')->with('pagos', $pago)->with('clientes', $cliente);  

      
    }

    public function pdf(Request $request)
    {
        //Trae el id del form de crear PDF de clientes.detalle
         $id = $request->input('id_pago');

            //Mostrar detalles de un cliente
            $cliente_id = Pago::find($id)->clientes_id;
            $cliente = Clientes::find($cliente_id);
            $pago = Pago::find($id);

       $data = array (
            'id' => $pago->id,
            'nombre' => $cliente->nombre,
            'concepto' => $pago->concepto,
            'total' => $pago->total,
            'entrega' => $pago->entrega,
            'saldo' =>  $pago->saldo,
            'fecha' => $pago->created_at
           
        );
        
            $pdf = PDF::loadView('clientes.pdf', $data ); 
            return $pdf->download($cliente->nombre.'_factura.pdf');     

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
