@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center"> 

        <div class="col-sm">
            <h2>Lista de pagos</h2>


                    <form method="POST" action="{{ route('clientes.store') }}">
                        @csrf
                        <input id="nombre" type="text" class="form-control" name="nombre" placeholder="Buscar" value="{{ old('nombre') }}" required autofocus>
                    </form>



            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th width="20px"> ID</th>
                        <th>Nombre</th>
                        <th>Debe</th>
                        <th colspan="3">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clientes as $cliente)
                         @foreach($cliente->pagos as $pagos)
                         <tr>
                             <td></td>
                             <td><a href="clientes/{{$pagos->id}}">{{$cliente->nombre}}</a></td>
                             <td><a href="clientes/{{$pagos->id}}">{{$pagos->saldo}}</a></td>
                         </tr>
                            

                        @endforeach

                    @endforeach
                </tbody>
            </table>
               {!! $clientes->render() !!}  
        </div>
    
       
      

    
        <div class="col-sm">
            <div class="card">
                
                <div class="card-body">
                <h2>Comprobante de Pago</h2>
                        <form method="POST" action="{{ route('clientes.store') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                                <div class="col-md-6">
                                    <input id="nombre" type="text" class="form-control" name="nombre" value="{{ old('nombre') }}" required autofocus>
                                
                                </div>
                            </div>

                              <div class="form-group row">
                                <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                
                                </div>
                            </div>


                              <div class="form-group row">
                                <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Telefono') }}</label>

                                <div class="col-md-6">
                                    <input id="telefono" type="text" class="form-control" name="telefono" value="{{ old('telefono') }}" required autofocus>
                                
                                </div>
                            </div>
                                <div class="form-group row">
                                    <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Concepto') }}</label>

                                    <div class="col-md-6">
                                        <input id="concepto" type="text" class="form-control" name="concepto" value="{{ old('concepto') }}" required autofocus>
                                    
                                    </div>
                                </div>

                                  <div class="form-group row">
                                    <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Total') }}</label>

                                    <div class="col-md-6">
                                        <input id="total" type="text" class="form-control" name="total" value="{{ old('total') }}" required autofocus>
                                    
                                    </div>
                                </div>


                                  <div class="form-group row">
                                    <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Entrega') }}</label>

                                    <div class="col-md-6">
                                        <input id="entrega" type="text" class="form-control" name="entrega" value="{{ old('entrega') }}" required autofocus>
                                    
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Saldo') }}</label>

                                    <div class="col-md-6">
                                        <input id="saldo" type="text" class="form-control" name="saldo" value="{{ old('saldo') }}" required autofocus>
                                    
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Guardar') }}
                                    </button>

                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Imprimir') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                </div>
            </div>
        </div>


    </div>


           
</div>

@endsection
