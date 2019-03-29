@extends('layouts.app')

@section('content')
     @if (auth()->user())

<div class="container"> 
    <div class="row justify-content-center"> 

        <div class="col-sm">
            <!--<h2>Lista de pagos</h2>-->

                <div class="cold-md-4">
                    {!! Form::open(['route'=> 'clientes.index', 'method'=>'GET', 'class'=>'navbar-form navbar.left pull-rigth', 'role'=>'search']) !!}
                    <div class="active-cyan-3 active-cyan-4 mb-4">
                        {!! Form::text('name', null, ['class'=> 'form-control', 'placeholder'=>'Buscar por: Nombre - Fecha: 2019-03-20  - Email - Teléfono', 'required']) !!}

                    </div>
                    <button type="submit" class="btn btn-primary">Buscar</button>
                    {!! Form::close() !!}
                

                  
                    
                </div>


            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th width="20px"> ID</th>
                        <th>Fecha</th>
                        <th>Nombre</th>
                        <th>Debe</th>
                        <th colspan="3">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clientes as $cliente)
                         @foreach($cliente->pagos as $pagos)
                         <tr>
                             <td></td>
                             <td>{{date_format($cliente->created_at, 'd/m/Y')}}</td>
                             <td><a href="clientes/{{$pagos->id}}">{{$cliente->nombre}}</a></td>
                             <td><a href="clientes/{{$pagos->id}}">{{number_format($pagos->saldo, 0, ',', '.')}}</a></td>
                         </tr>
                            

                        @endforeach

                    @endforeach
                </tbody>
            </table>
               {!! $clientes->render() !!}  
        </div>
    
       
      

    
        <div class="col-sm">
            <div class="card">
                
                <div class="card-body">

                             

                <!--<h2>Comprobante de Pago</h2>-->
                        <form method="POST" action="{{ route('clientes.store') }}" name="f">
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
                                <div class="form-group row">
                                    <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Concepto') }}</label>

                                    <div class="col-md-6">
                                        <input id="concepto" type="text" class="form-control" name="concepto" value="{{ old('concepto') }}" required autofocus>
                                    
                                    </div>
                                </div>






                                  <div class="form-group row">
                                    <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Total') }}</label>

                                    <div class="col-md-6">
                                        <input id="total" type="text" class="form-control" name="total" value="{{ old('total') }}" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))" onchange="cal()" required autofocus>
                                    
                                    </div>
                                </div>


                                  <div class="form-group row">
                                    <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Entrega') }}</label>

                                    <div class="col-md-6">
                                        <input id="entrega" type="text" class="form-control" name="entrega" value="{{ old('entrega') }}" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))" onchange="cal()"  required autofocus>
                                    
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Saldo') }}</label>

                                    <div class="col-md-6">

                                        <input id="saldo" type="text" class="form-control" name="saldo" value="{{ old('saldo') }}" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))" required autofocus readonly="readonly">
                                    
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Guardar y enviar') }}
                                    </button>

                                   
                                </div>
                            </div>
                        </form>
                </div>
            </div>
        </div>


    </div>


           
</div>


        @else
            <h1>No tienes permiso </h1>
        @endif


@endsection



<script language="JavaScript">
//Código para colocar 
//los indicadores de miles mientras se escribe
//script por tunait!
function puntitos(donde,caracter)
{
pat = /[\*,\+,\(,\),\?,\\,\$,\[,\],\^]/
valor = donde.value
largo = valor.length
crtr = true
if(isNaN(caracter) || pat.test(caracter) == true)
    {
    if (pat.test(caracter)==true) 
        {caracter = "\\" + caracter}
    carcter = new RegExp(caracter,"g")
    valor = valor.replace(carcter,"")
    donde.value = valor
    crtr = false
    }
else
    {
    var nums = new Array()
    cont = 0
    for(m=0;m<largo;m++)
        {
        if(valor.charAt(m) == "," || valor.charAt(m) == " ")
            {continue;}
        else{
            nums[cont] = valor.charAt(m)
            cont++
            }
        
        }
    }


var cad1="",cad2="",tres=0
if(largo > 3 && crtr == true)
    {
    for (k=nums.length-1;k>=0;k--)
        {
        cad1 = nums[k]
        cad2 = cad1 + cad2
        tres++
        if((tres%3) == 0)
            {
            if(k!=0){
                cad2 = "," + cad2
                }
            }
        }
     donde.value = cad2
    }
}   
</script>

                                <script>function cal() {
                                  try {
                                    var a = document.f.total.value,
                                        b = document.f.entrega.value;

                                    var a = a.replace(/,/g, "");
                                    var b = b.replace(/,/g, "");
                                    document.f.saldo.value = a - b;

                                     } catch (e) {
                                  }
                                }</script>