@extends('layouts.app')

@section('content')
<div class="container">
    <tabla-movimientos-component></tabla-movimientos-component>
    <p class="h2">Total en caja del día: {{$total}}<span id="total"></span></p>
</div>
<apertura-component :mostrar="{{ $apertura ? "true" : "false" }}"></apertura-component>
@endsection
