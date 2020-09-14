@extends('layouts.app')

@section('content')

<div class="container">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#nuevoProducto" onclick="nuevo()">+ Nuevo Producto</button>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#nuevaCategoria">+ Nueva Categoría</button>

    <div class="row justify-content-center">
    <tabla-ventas-component></tabla-ventas-component>
    </div>


@endsection


