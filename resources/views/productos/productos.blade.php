@extends('layouts.app')

@section('content')

<div class="container">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#nuevoProducto" onclick="nuevo()">+ Nuevo Producto</button>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#nuevaCategoria">+ Nueva Categoría</button>

    <div class="row justify-content-center">
        <table class="table table-hover thead-light text-center">
                    <thead>
                        <th>Categoria</th>
                        <th>Producto</th>
                        <th>Descripción</th>
                        <th>Stock actual</th>
                        <th>Stock mínimo</th>
                        <th>Precio de venta</th>
                        <th>Precio de compra</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody>
                        @foreach ($productos as $item)
                        <tr>
                            <td>{{$item -> categoria_producto -> nombre}}</td>
                            <td>{{$item -> nombre}}</td>
                            <td>{{$item -> descripcion}}</td>
                            <td>{{$item -> stock_actual}}</td>
                            <td>{{$item -> stock_minimo}}</td>
                            <td>{{number_format($item -> precio_venta)}}</td>
                            <td>{{number_format($item -> precio_compra)}}</td>
                            <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#nuevoProducto" onclick="modificar({{$item}})">Modificar</button>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#eliminar" onclick="confirmarEliminar({{$item->id}})">Eliminar</button></td>
                        </tr>
                        @endforeach
                    </tbody>
        </table>
        <div class="modal fade" id="nuevoProducto" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title producto">Nuevo Producto</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form id="mov" method="POST" action="{{ route('productos.store') }}">
                        @csrf
                        <div class="modal-body">

                            <div hidden>
                                <input id="id" type="number" name="id">
                            </div>

                            <div class="form-group row">
                                <label for="nombre" class="col-md-4 col-form-label text-md-right">Nombre del Producto</label>
                                <div class="col-md-6">
                                    <input autocomplete="off" id="producto" name="producto" class="form-control" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="descripcion" class="col-md-4 col-form-label text-md-right">Descripción</label>
                                <div class="col-md-6">
                                    <input id="descripcion" name="descripcion" autocomplete="off" class="form-control" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="stock_actual" class="col-md-4 col-form-label text-md-right">Stock Actual</label>
                                <div class="col-md-6">
                                    <input id="stock_actual" name="stock_actual" type="number" autocomplete="off" class="form-control" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="stock_minimo" class="col-md-4 col-form-label text-md-right">Stock Minimo</label>
                                <div class="col-md-6">
                                    <input id="stock_minimo" name="stock_minimo" autocomplete="off" class="form-control" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="precio_venta" class="col-md-4 col-form-label text-md-right">Precio de Venta</label>
                                <div class="col-md-6">
                                    <input id="precio_venta" name="precio_venta" min="1" autocomplete="off" class="form-control" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="precio_compra" class="col-md-4 col-form-label text-md-right">Precio de Compra</label>
                                <div class="col-md-6">
                                    <input id="precio_compra" name="precio_compra" min="1" autocomplete="off" class="form-control" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="categoria" class="col-md-4 col-form-label text-md-right">Categoria</label>
                                <div class="col-md-6">
                                    <select name="categoria" id="categoria" class="form-control" required>
                                        @foreach( $categorias as $item )
                                            <option value="{{ $item -> id }}">{{ $item -> nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" value="submit">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="nuevaCategoria" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nueva Categoría</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('categorias_producto.store') }}">
                        @csrf
                        <div class="modal-body">

                        <div class="form-group row">
                                <label for="nombre" class="col-md-4 col-form-label text-md-right">Nombre</label>
                                <div class="col-md-6">
                                    <input id="nombre" name="nombre" autocomplete="off" class="form-control" required autofocus>
                                </div>
                            </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" value="submit">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="eliminar" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="" id="eliminarForm" method="post">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5>Eliminar Producto</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <p class="text-center">Desea realmente eliminar este registro?</p>
                    </div>
                    <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button>
                            <button type="submit" name="" class="btn btn-danger" data-dismiss="modal" onclick="eliminar()">Eliminar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


<script language="JavaScript">
function confirmarEliminar(id)
     {
         var id = id;
         var url = '{{ route("productos.destroy", ":id") }}';
         url = url.replace(':id', id);
         $("#eliminarForm").attr('action', url);
     }

     function eliminar()
     {
         $("#eliminarForm").submit();
     }

    function nuevo(){
        $('.producto')[0].innerHTML = 'Nuevo Producto';
        $('#id')[0].value = '';
        $('#producto')[0].value = '';
        $('#descripcion')[0].value = '';
        $('#stock_actual')[0].value = '';
        $('#stock_minimo')[0].value = '';
        $('#precio_venta')[0].value = '';
        $('#precio_compra')[0].value = '';
        $('#categoria')[0].value = 0;
    }

    function modificar(objeto){
        $('.producto')[0].innerHTML = 'Editar Producto';
        $('#id')[0].value = objeto.id;
        $('#producto')[0].value = objeto.nombre;
        $('#descripcion')[0].value = objeto.descripcion;
        $('#stock_actual')[0].value = objeto.stock_actual;
        $('#stock_minimo')[0].value = objeto.stock_minimo;
        $('#precio_venta')[0].value = objeto.precio_venta;
        $('#precio_compra')[0].value = objeto.precio_compra;
        $('#categoria')[0].value = objeto.categoria_producto_id;
        puntitos($('#precio_venta')[0],$('#precio_venta')[0].value.charAt($('#precio_venta')[0].value.length-1));
        puntitos($('#precio_compra')[0],$('#precio_compra')[0].value.charAt($('#precio_compra')[0].value.length-1));
    }
//Código para colocar
//los indicadores de miles mientras se escribe
//script por tunait!
    function puntitos(donde,caracter){
        pat = /[\*,\+,\(,\),\?,\\,\$,\[,\],\^]/;
        valor = donde.value;
        largo = valor.length;
        crtr = true;
        if(isNaN(caracter) || pat.test(caracter)){
            if (pat.test(caracter)){
                caracter = "\\" + caracter;
            }
            carcter = new RegExp(caracter,"g");
            valor = valor.replace(carcter,"");
            donde.value = valor;
            crtr = false;
        }
        else{
            var nums = new Array();
            cont = 0;
            for(m=0;m<largo;m++){
                if(!(valor.charAt(m) == "," || valor.charAt(m) == " ")){
                    nums[cont] = valor.charAt(m);
                    cont++;
                }
            }
        }

        var cad1="",cad2="",tres=0;
        if(largo > 3 && crtr){
            for (k=nums.length-1;k>=0;k--){
                cad1 = nums[k];
                cad2 = cad1 + cad2;
                tres++;
                if((tres%3) == 0){
                    if(k!=0){
                        cad2 = "," + cad2;
                    }
                }
            }
            donde.value = cad2;
        }
    }
</script>
@endsection


