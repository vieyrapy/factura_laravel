@extends('layouts.app')

@section('content')

<div class="container"> 
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#nuevoMov" onclick="fecha()">+ Nuevo Movimiento</button>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#nuevoCat">+ Nueva Categoría</button>
    <form method="POST" class="d-inline-block" action="{{ route('reporte') }}"> 
        @csrf
        <div hidden>
            <input id="cat_filtro" type="text" name="cat_filtro" value="{{ isset($_GET['cat_filtro']) ? $_GET['cat_filtro'] : '' }}">
        </div> 
        <div hidden>
            <input id="filtro" type="text" name="filtro" value="{{ isset($_GET['filtro']) ? $_GET['filtro'] : '1' }}">
        </div>   
        <div hidden>
            <input id="date_ini" type="text" name="date_ini" value="{{ isset($_GET['date_ini']) ? $_GET['date_ini'] : '' }}">
        </div>
        <div hidden>
            <input id="date_fin" type="text" name="date_fin" value="{{ isset($_GET['date_fin']) ? $_GET['date_fin'] : '' }}">
        </div>
        <div hidden>
            <input id="month_ini" type="text" name="month_ini" value="{{ isset($_GET['month_ini']) ? $_GET['month_ini'] : '' }}">
        </div>
        <div hidden>
            <input id="month_fin" type="text" name="month_fin" value="{{ isset($_GET['month_fin']) ? $_GET['month_fin'] : '' }}">
        </div>
        <div hidden>
            <input id="year_ini" type="text" name="year_ini" value="{{ isset($_GET['year_ini']) ? $_GET['year_ini'] : '' }}">
        </div>
        <div hidden>
            <input id="year_fin" type="text" name="year_fin" value="{{ isset($_GET['year_fin']) ? $_GET['year_fin'] : '' }}">
        </div>           

        <button type="submit" class="btn btn-primary" value="submit">Generar PDF</button>
    </form>

    <div class="m-3">
    <form class="form-inline">
        <div class="col-6 d-inline-block">
            <select name="cat_filtro" class="custom-select w-50" onchange="habilitarCat(this.value)">
                <option selected>Filtrar Categorias</option>
                @foreach($categoria as $c)
                    <option value="{{$c -> id}}">{{$c -> nombreCategoria}}</option>
                @endforeach
            </select>
            <select name="filtro" class="custom-select" style="width:49%" onchange="filtros(this)">
                <option value="1" selected>Filtrar según Fechas</option>
                <option value="2">Filtrar según Meses</option>
                <option value="3">Filtrar según Años</option>
            </select>
        </div>
        <div class="col-6 d-inline-block float-right">
            

                <label class="d-inline-block">Desde:</label >
                {!! Form::date('date_ini', null, ['class'=> 'form-control d-inline-block date w-25', 'onchange' => 'habilitar()']) !!}
                {!! Form::month('month_ini', null, ['class'=> 'form-control d-none month w-25', 'onchange' => 'habilitar()']) !!}
                {!! Form::select('year_ini', array('' => '...') + range(date('Y'),1940), null, ['class'=> 'form-control d-none year w-25', 'onchange' => 'habilitar()']) !!}
            
                <label class="d-inline-block">Hasta:</label>
                {!! Form::date('date_fin', null, ['class'=> 'form-control d-inline-block date w-25', 'onchange' => 'habilitar()']) !!}
                {!! Form::month('month_fin', null, ['class'=> 'form-control d-none month w-25', 'onchange' => 'habilitar()']) !!}
                {!! Form::select('year_fin', array('' => '...') + range(date('Y'),1940), null, ['class'=> 'form-control d-none year w-25', 'onchange' => 'habilitar()']) !!}

                <button id="filtrar" class="btn btn-outline-success my-2 my-sm-0" type="submit" disabled>Buscar</button>
           
        </div>
        </form>
    </div>

    <div class="row justify-content-center">
    {!! $movimiento->render() !!}
        <table class="table table-hover thead-light text-center">
                    <thead>
                        <th>Fecha</th>
                        <th>Categoria</th>
                        @if($filtro == 1)
                        <th>Nombre</th>
                        <th>Concepto</th>
                        @endif
                        <th>Ingreso</th>
                        <th>Egreso</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody>
                        @foreach($movimiento as $m)
                            <tr>
                                <td>{{$m -> fecha}}</td>
                                <td>{{$m -> categoria -> nombreCategoria}}</td>
                                @if(!($filtro > 1))
                                <td>{{$m -> entidad}}</td>
                                <td>{{$m -> concepto}}</td>
                                @endif
                                <td>{{number_format($m -> ingreso)}}</td>
                                <td>{{number_format($m -> egreso)}}</td>
                                <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#nuevoMov" onclick="modificar({{$m}})">Modificar</button> 
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#eliminar" onclick="confirmarEliminar({{$m->id}})">Eliminar</button></td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="{{!($filtro > 1) ? 4 : 3}}">Totales: </td>
                            <td>{{number_format($totales[0])}}</td>
                            <td>{{number_format($totales[1])}}</td>
                        </tr>
                        <tr>
                            <td colspan="{{!($filtro > 1) ? 4 : 3}}">Total final: </td>
                            <td colspan="2">{{number_format($totales[0] - $totales[1])}}</td>
                        </tr>
                    </tbody>
        </table>
        <div class="modal fade" id="nuevoMov" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title movimiento">Nuevo Movimiento</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <form id="mov" method="POST" action="{{ route('movimiento.store') }}"> 
                        @csrf
                        <div class="modal-body">

                            <div hidden>
                                <input id="id" type="number" name="id">
                            </div> 

                            <div class="form-group row">
                                <label for="fecha" class="col-md-4 col-form-label text-md-right">Fecha</label>
                                <div class="col-md-6">
                                    <input autocomplete="off" id="fecha" type="date" class="form-control" name="fecha" required autofocus>        
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="nombre" class="col-md-4 col-form-label text-md-right">Nombre</label>
                                <div class="col-md-6">
                                    <input id="nombre" autocomplete="off" type="text" class="form-control" name="nombre" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="categoria" class="col-md-4 col-form-label text-md-right">Categoria</label>
                                <div class="col-md-6">
                                    <select name="categoria" id="categoria" class="form-control" required>
                                        @foreach($categoria as $c)
                                            <option value="{{$c->id}}">{{$c->nombreCategoria}}</option>
                                        @endforeach
                                    </select>  
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="concepto" class="col-md-4 col-form-label text-md-right">Concepto</label>
                                <div class="col-md-6">
                                    <input id="concepto" type="text" autocomplete="off" class="form-control" name="concepto" required autofocus>        
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Tipo de movimiento</label>
                                    <div class="col-3 align-self-center text-center">
                                        <input type="radio" id="ingreso" name="tipo" value="Ingreso"><label for="ingreso">&nbsp Ingreso</label>
                                    </div>
                                    <div class="col-3 align-self-center text-center">
                                        <input type="radio" id="egreso" name="tipo" value="Egreso"><label for="egreso">&nbsp Egreso</label>
                                    </div>
                            </div>

                            <div class="form-group row">
                                <label for="monto" class="col-md-4 col-form-label text-md-right">Monto</label>
                                <div class="col-md-6">
                                    <input id="monto" type="text" min="1" autocomplete="off" class="form-control" name="monto" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))" required autofocus>  
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

        <div class="modal fade" id="nuevoCat" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nueva Categoría</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <form method="POST" action="{{ route('categoria.store') }}"> 
                        @csrf
                        <div class="modal-body">

                        <div class="form-group row">
                                <label for="nombre" class="col-md-4 col-form-label text-md-right">Nombre</label>
                                <div class="col-md-6">
                                    <input id="nombre" name="nombre" type="text" autocomplete="off" class="form-control" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="descripcion" class="col-md-4 col-form-label text-md-right">Descripción</label>
                                <div class="col-md-6">
                                    <input id="descripcion" name="descripcion" autocomplete="off" type="text" class="form-control" required autofocus>        
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
                        <h5>Eliminar Movimiento</h5>
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
         var url = '{{ route("movimientos.destroy", ":id") }}';
         url = url.replace(':id', id);
         $("#eliminarForm").attr('action', url);
     }

     function eliminar()
     {
         $("#eliminarForm").submit();
     }

    function filtros(opcion){
        let ver = opcion.value,
        date = $(".date"),
        month = $(".month"),
        year = $(".year");
        switch(ver){
            case '1':
                for(i = 0; i <= 1; i++){
                    date[i].classList.replace('d-none', 'd-inline-block');
                    month[i].classList.replace('d-inline-block', 'd-none');
                    year[i].classList.replace('d-inline-block', 'd-none');
                    month[i].value = "";
                    year[i].value = "";
                }
                break;
            case '2':
                for(i = 0; i <= 1; i++){
                    month[i].classList.replace('d-none', 'd-inline-block');
                    date[i].classList.replace('d-inline-block', 'd-none');
                    year[i].classList.replace('d-inline-block', 'd-none');
                    date[i].value = "";
                    year[i].value = "";
                }
                break;
            case '3':
                for(i = 0; i <= 1; i++){
                    year[i].classList.replace('d-none', 'd-inline-block');
                    month[i].classList.replace('d-inline-block', 'd-none');
                    date[i].classList.replace('d-inline-block', 'd-none');
                    month[i].value = "";
                    date[i].value = "";
                }
                break;
        }
        if($('#cat_filtro').value > 0){
            $('#filtrar')[0].disabled=true;
        }
    }

    function habilitar(){
        $('#filtrar')[0].disabled=false;
    }

    function habilitarCat(valor){
        valor > 0 ? $('#filtrar')[0].disabled=false : $('#filtrar')[0].disabled=true;
    }

    function fecha(){
        $('#fecha')[0].setAttribute('max', new Date().toISOString().split('T')[0]);
        $('.movimiento')[0].innerHTML = 'Nuevo Movimiento';
        $('#fecha')[0].value = new Date();
        $('#nombre')[0].value = '';
        $('#categoria')[0].value = 1;
        $('#concepto')[0].value = '';
        $("[name = 'tipo']")[0].checked = false;
        $("[name = 'tipo']")[1].checked = false;
        $('#monto')[0].value = '';
    }

    function modificar(objeto){
        $('#fecha')[0].setAttribute('max', new Date().toISOString().split('T')[0]);
        $('.movimiento')[0].innerHTML = 'Editar Movimiento';
        $('#id')[0].value = objeto.id;
        $('#fecha')[0].value = objeto.fecha;
        $('#nombre')[0].value = objeto.entidad;
        $('#categoria')[0].value = objeto.categoria_id;
        $('#concepto')[0].value = objeto.concepto;
        $("[value = '" + objeto.tipo_movimiento + "']")[0].checked = true;
        $('#monto')[0].value = objeto.monto;
        puntitos($('#monto')[0],$('#monto')[0].value.charAt($('#monto')[0].value.length-1));
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


