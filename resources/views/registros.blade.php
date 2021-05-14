@extends('layouts.app')

@section('content')
<div class="container">
    <tabla-movimientos-component></tabla-movimientos-component>
</div>
<apertura-component :mostrar="{{ $apertura ? "true" : "false" }}"></apertura-component>
@endsection
