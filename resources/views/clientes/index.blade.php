@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center"> 
    <div class="col-sm">
        <h2>Ejemplo de un foreach con lista 1</h2>
            <ul>
                @foreach($clientes as $cliente)
                <li>{{ $cliente-> nombre}}</li>


                    <!--Ejemplo de un foreach dentro de un forech con formularios anidados-->

                    @foreach($cliente->pagos as $pagos)
                        <strong>Fecha:</strong>{{$pagos->created_at}}<br>
                        <strong>Concepto:</strong>{{$pagos->concepto}}<br>
                        <strong>Total:</strong>{{$pagos->total}}<br>
                        <strong>Entrega:</strong>{{$pagos->entrega}}<br>
                        <strong>Saldo:</strong>{{$pagos->saldo}}<br>
                    @endforeach

                @endforeach
            </ul>
</div>
    
       
           @if(count($pagos)>0)
                @foreach($cliente->pagos as $pagos)
                <div class="card">
                     <h2>Ejemplo de un foreach con lista 2</h2>
                    <div class="card-body">
                        <h3><a href="clientes/{{$pagos->id}}">{{$cliente->nombre}}</a></h3>
                    </div>
                </div>

                @endforeach
            @endif
            

    
        <div class="col-sm">
            <div class="card">
                
                <div class="card-body">
                <h1>Formulario Cliente</h1>
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
                                </div>
                            </div>
                        </form>
                </div>
            </div>
        </div>


    </div>


           
</div>
@endsection
