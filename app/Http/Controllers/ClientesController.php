<?php

namespace App\Http\Controllers;
 
use App\Clientes;
use App\Pago;
use Illuminate\Http\Request;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Creamos una variable en este caso $cliente y le pedimos que traiga todos los clientes de la BD 
        // Laravel utiliza ORM = Object Relational Mapping
        $cliente = Clientes::all();

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

    
        //Realizamos primero una validación a todos los campos 
        //$this->validate($request, [
         //   'nombre' => 'requerid',
          //  'email' => 'requerid',
        //    'telefono' => 'requerid'
       // ]);
          //Crear un nuevo cliente en nuestra base de datos
          $cliente = new Clientes;
          $cliente->nombre = $request->input('nombre');  
          $cliente->email = $request->input('email');
          $cliente->telefono = $request->input('telefono');
          $cliente->save();


        $cliente_id = Clientes::all()->last()->id;

          $pago = new Pago;
          $pago-> concepto  = $request->input('concepto');
          $pago-> total = $request->input('total');
          $pago-> entrega = $request->input('entrega');
          $pago-> saldo = $request->input('saldo');
          $pago-> clientes_id =  $cliente_id;
          $pago->save();
          //realizar un mensaje de guardado 
          return redirect(' ')->with('success', 'Cliente guardado');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function show(Clientes $clientes)
    {
        //
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
