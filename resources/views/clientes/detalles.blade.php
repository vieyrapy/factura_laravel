@extends('layouts.app')

@section('content')

                <div class="card">
                    <div class="card-body">
                        <a href="../clientes" class="btn btn-default float-right">Volver</a>
                        <strong>Cliente:</strong>{{$pagos->clientes_id}}<br>
                        <strong>Fecha:</strong>{{$pagos->created_at}}<br>
                        <strong>Concepto:</strong>{{$pagos->concepto}}<br>
                        <strong>Total:</strong>{{$pagos->total}}<br>
                        <strong>Entrega:</strong>{{$pagos->entrega}}<br>
                        <strong>Saldo:</strong>{{$pagos->saldo}}<br>
                        
                    </div>
                </div>

               
@endsection
