@extends('layouts.app')

@section('content')
<div class="container">
    <button id="boton" type="button" class="d-none" data-toggle="modal" data-target="#apertura">
        Launch modal
    </button>
</div>
<apertura-component :mostrar="{{ $apertura ? "true" : "false" }}"></apertura-component>
@endsection
