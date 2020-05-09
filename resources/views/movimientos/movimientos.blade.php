@extends('layouts.app')

@section('content')

<div class="container"> 
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#nuevoMov">+ Nuevo Movimiento</button>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#nuevoCat">+ Nueva Categoría</button>
    <form method="POST" class="d-inline-block" action="{{ route('reporte') }}"> 
        @csrf
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
        <div class="col-6 d-inline-block">
            <select class="custom-select" onchange="filtros(this)">
                <option selected>Filtrar por...</option>
                <option value="1">Fechas</option>
                <option value="2">Meses</option>
                <option value="3">Años</option>
            </select>
        </div>
        <div class="col-6 d-inline-block float-right">
            <form class="form-inline">

                <label id="desde" class="d-none">Desde:</label >
                {!! Form::date('date_ini', null, ['class'=> 'form-control d-none date w-25']) !!}
                {!! Form::month('month_ini', null, ['class'=> 'form-control d-none month w-25']) !!}
                {!! Form::select('year_ini', array('' => '...') + range(1940,date('Y')), null, ['class'=> 'form-control d-none year w-25']) !!}
            
                <label class="d-none" id="hasta">Hasta:</label>
                {!! Form::date('date_fin', null, ['class'=> 'form-control d-none date w-25']) !!}
                {!! Form::month('month_fin', null, ['class'=> 'form-control d-none month w-25']) !!}
                {!! Form::select('year_fin', array('' => '...') + range(1940,date('Y')), null, ['class'=> 'form-control d-none year w-25']) !!}

                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
            </form>
        </div>
    </div>

    <div class="row justify-content-center">
        <table class="table table-hover thead-light text-center">
            <thead>
                <th>Fecha</th>
                <th>Nombre</th>
                <th>Categoria</th>
                <th>Concepto</th>
                <th>Ingreso</th>
                <th>Egreso</th>
            </thead>
            <tbody>
                @foreach($movimiento as $m)
                    <tr>
                        <td>{{date_format(new DateTime($m -> fecha), 'd/m/Y')}}</td>
                        <td>{{$m -> entidad}}</td>
                        <td>{{$m -> categoria -> nombreCategoria}}</td>
                        <td>{{$m -> concepto}}</td>
                        <td>{{number_format($m -> ingreso)}}</td>
                        <td>{{number_format($m -> egreso)}}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4">Totales: </td>
                    <td>{{number_format($totales[0])}}</td>
                    <td>{{number_format($totales[1])}}</td>
                </tr>
                <tr>
                    <td colspan="4">Total final: </td>
                    <td colspan="2">{{number_format($totales[0] - $totales[1])}}</td>
                </tr>
            </tbody>
        </table>
        <div class="modal fade" id="nuevoMov" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nuevo Movimiento</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <form method="POST" action="{{ route('movimiento.store') }}"> 
                        @csrf
                        <div class="modal-body">

                            <div class="form-group row">
                                <label for="fecha" class="col-md-4 col-form-label text-md-right">Fecha</label>
                                <div class="col-md-6">
                                    <input id="fecha" type="date" class="form-control" name="fecha" required autofocus>        
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="nombre" class="col-md-4 col-form-label text-md-right">Nombre</label>
                                <div class="col-md-6">
                                    <input id="nombre" type="text" class="form-control" name="nombre" required autofocus>
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
                                    <input id="concepto" type="text" class="form-control" name="concepto" required autofocus>        
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
                                    <input id="monto" type="text" min="1" pattern="^[0-9]+" class="form-control" name="monto" required autofocus>  
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
                                    <input id="nombre" name="nombre" type="text" class="form-control" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="descripcion" class="col-md-4 col-form-label text-md-right">Descripción</label>
                                <div class="col-md-6">
                                    <input id="descripcion" name="descripcion" type="text" class="form-control" required autofocus>        
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


<script language="JavaScript">

    function filtros(opcion){
        let ver = opcion.value,
        desde = $('#desde')[0],
        hasta = $('#hasta')[0],
        date = $(".date"),
        month = $(".month"),
        year = $(".year");
        desde.className = 'd-inline-block';
        hasta.className = 'd-inline-block';
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
            default:
                desde.className = 'd-none';
                hasta.className = 'd-none';
                for(i = 0; i <= 1; i++){
                    date[i].classList.replace('d-inline-block', 'd-none');
                    month[i].classList.replace('d-inline-block', 'd-none');
                    year[i].classList.replace('d-inline-block', 'd-none');
                    month[i].value = "";
                    year[i].value = "";
                    date[i].value = "";
                }
                break;
        }
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


