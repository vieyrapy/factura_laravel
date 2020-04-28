@extends('layouts.app')

@section('content')

<div class="container"> 
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#nuevoMov">+ Nuevo Movimiento</button>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#nuevoCat">+ Nueva Categoría</button>
    <button type="button" class="btn btn-primary">Imprimir reporte</button>

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
            <label id="desde" class="d-none">Desde:</label >
            <input type="date" name="date" class="d-none">
            <input type="month" name="month" class="d-none">
            <select name="year" class="d-none">
                @for($i = date('Y'); $i >= 1940; $i--)
                    <option value="{{$i}}">{{$i}}</option>
                @endfor
            </select>
            <label class="d-none ml-2" id="hasta">Hasta:</label>
            <input type="date" class="d-none" name="date">
            <input type="month" class="d-none" name="month">
            <select name="year" class="d-none" name="year">
                @for($i = date('Y'); $i >= 1940; $i--)
                    <option value="{{$i}}">{{$i}}</option>
                @endfor
            </select>
        </div>
    </div>

    <div class="row justify-content-center">
        <table class="table table-hover thead-light text-center">
            <thead>
                <th>Fecha</th>
                <th>Nombre</th>
                <th>Categoria</th>
                <th>Concepto</th>
                <th>Monto</th>
                <th>Tipo de movimiento</th>
            </thead>
            <tbody>
                @foreach($movimiento as $m)
                    <tr>
                        <td>{{$m -> fecha}}</td>
                        <td>{{$m -> entidad}}</td>
                        <td>{{$m -> nombreCategoria}}</td>
                        <td>{{$m -> concepto}}</td>
                        <td>{{$m -> monto}}</td>
                        <td>{{$m -> tipo_movimiento}}</td>
                    </tr>
                @endforeach
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
                                    <input id="categoria" type="text" class="form-control" name="categoria" required autofocus>        
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
                    
                    <form method="POST" action="#"> 
                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="nombre" class="col-md-4 col-form-label text-md-right">Nombre</label>
                                <div class="col-md-6">
                                    <input id="nombre" type="text" class="form-control" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="descripcion" class="col-md-4 col-form-label text-md-right">Descripción</label>
                                <div class="col-md-6">
                                    <input id="concepto" type="text" class="form-control" required autofocus>        
                                </div>
                            </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>       
</div>


<script language="JavaScript">

    function filtros(opcion){
        let ver = opcion.value,
        desde = $('#desde')[0],
        hasta = $('#hasta')[0],
        date = $("[name='date']"),
        month = $("[name='month']"),
        year = $("[name='year']");
        desde.classList.remove('d-none');
        hasta.classList.remove('d-none');
        console.log(date);
        switch(ver){
            case '1':
                for(i = 0; i <= 1; i++){
                    date[i].classList.remove('d-none');
                    month[i].className = 'd-none';
                    year[i].className = 'd-none';
                }
                break;
            case '2':
                for(i = 0; i <= 1; i++){
                    month[i].classList.remove('d-none');
                    date[i].className = 'd-none';
                    year[i].className = 'd-none';
                }
                break;
            case '3':
                for(i = 0; i <= 1; i++){
                    year[i].classList.remove('d-none');
                    month[i].className = 'd-none';
                    date[i].className = 'd-none';
                }
                break;
            default:
                desde.className = 'd-none';
                hasta[0].className = 'd-none';
                for(i = 0; i <= 1; i++){
                    date[i].className = 'd-none';
                    month[i].className = 'd-none';
                    year[i].className = 'd-none';
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


