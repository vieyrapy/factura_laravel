@extends('layouts.app')

@section('content')
<div class="container">
        <h2>Ejemplo de un foreach</h2>
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


    <div class="row justify-content-center"> 
        <div class="col-md-8">
            <div class="card">
            <h1>Formulario</h1>

            
            
            <div class="card-body">
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



                            <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Guardar') }}
                                </button>
                            </div>
                        </div>
    
            </div>
        </div>
    </div>
</div>
@endsection
