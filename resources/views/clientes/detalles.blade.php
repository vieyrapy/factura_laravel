
@extends('layouts.app')
@section('content') 

<div class="container">

    <div class="row">
        <div class="col-md-6 offset-md-3">
                                <div style="background-color:#ffffff" >
                                            <a href="#m_-6108734568478989486_">
                                                <img src="http://rocemi.com.py/wp-content/uploads/2019/03/sds-nav-emails.jpg" width="100%" border="0" alt="Studio Sanchez" >
                                            </a>
                                </div>
        </div>
    </div> 

    <div class="row">
        <div class="col-md-6 offset-md-3">
                                            <br>
                                            <br>
                                            <P style="color:#4a4a4a;font-size:18px;font-family:'Lato-Regular',Lato,sans-serif" align="center" >
                                                <b>{{$clientes->nombre}}</b>, acontinuación se detalla el pago realizado por: <b>{{$pagos->concepto}}.</b>
                                            </P>
                                            <br>                                                                              
        </div>
    </div>

    <div class="row">
        <div class="col-md-1">
        </div>

        <div class="col-sm-2 col-md-2 offset-sm-3 offset-md-3">
                <form method="POST" action="{{ route('pdf')}}"> 
                                            @csrf
                                                    <button type="submit" class="btn btn-outline-dark btn-lm">
                                                        {{ __('Descargar recibo') }}
                                                    </button>
                                               
                                             <div class="form-group row">
                                                <div hidden>
                                                    <input id="id_pago" type="text" class="form-control" name="id_pago" value="{{$pagos->id}}" required autofocus>
                                                </div>
                                            </div>
                </form>                           
        </div>

        <div class="col-sm-2 col-md-2  ">
             <a target="_blank" href="https://api.whatsapp.com/send?phone=595{{substr($clientes->telefono,1)}}&text=%0a%0a*{{$clientes->nombre}}*,%20gracias%20por%20tu%20preferencia.%0a%0a*COMPROBANTE%20DE%20PAGO%20Nº:*%20{{$pagos->id}}%0aEncarnación,%20{{date_format($pagos->created_at, 'd/m/Y')}}%0a%20*Entrega:%20Gs.*%20{{number_format($pagos->entrega, 0, ',', '.')}}%0a%20Total:%20Gs. {{number_format($pagos->total, 0, ',', '.')}}%0a%20Saldo:%20Gs. {{number_format($pagos->saldo, 0, ',', '.')}}%0a%20Concepto:%20{{$pagos->concepto}}.%0a%0a📸%20*Studio%20Sánchez*%0a☎%20071%20208206%20|%200982-359850%20"><button type="button" class="btn btn-outline-dark btn-lm" >Enviar Whatsapp!</button></a>
             <br>
             <br>   
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 offset-md-3">
                                                                <div style="font-family:'Lato-Light',Lato,sans-serif;font-size:20px;color:#4a4a4a">
                                                                    {{date_format($pagos->created_at, 'd/m/Y')}}
                                                                </div>
                                                         

                                                            
                                                                <div style="color:#9b9b9b;font-size:12px;text-align:left;font-family:'Lato-Regular',Lato,sans-serif">
                                                                    Fecha de pago
                                                                
                                                                </div>
                                                         
                                                         

                                                            
                                                                <div style="color:#003278;font-size:40px;font-family:'Lato-Regular',Lato,sans-serif;font-weight:900">
                                                                    <b>Gs. {{number_format($pagos->entrega, 0, ',', '.')}}</b>
                                                                </div>

                                                       

                                                            
                                                                <div style="font-family:'Lato-Regular',Lato,sans-serif;font-size:12px;font-weight:900;color:#4a4a4a">
                                                                    PAGO REALIZADO
                                                                </div>
                                                        
                                                        
                                                       
                                                             
                                                                <div style="font-family:'Lato-Light',Lato,sans-serif;font-size:30px;color:#4a4a4a">
                                                                    <b>Gs. {{number_format($pagos->total, 0, ',', '.')}}</b>
                                                                </div>
                                                          
                                                            
                                                                <div style="font-family:'Lato-Regular',Lato,sans-serif;font-size:12px;font-weight:900;color:#4a4a4a">
                                                                    DEUDA TOTAL
                                                                </div>
                                                         
                                                           
                                                         
                                                             
                                                                <div style="font-family:'Lato-Light',Lato,sans-serif;font-size:30px;color:#ff7800">
                                                                    <b>Gs. {{number_format($pagos->saldo, 0, ',', '.')}}</b>
                                                                </div>
                                                           
                                                            
                                                                <div style="font-family:'Lato-Regular',Lato,sans-serif;font-size:12px;font-weight:900;color:#4a4a4a">
                                                                    SALDO 
                                                                </div>
                                                         
                                                        
                                                            
                                                                <div style="font-family:'Lato-Regular',Lato,sans-serif;font-size:14px;font-weight:900;color:#4a4a4a">
                                                                    <br>
                                                                    <br>
                                                                    TELEFONO: <b>{{$clientes->telefono}}</b> 
                                                                    <br>
                                                                    E-MAIL: <b>{{$clientes->email}}</b>
                                                                    <br>
                                                                    ID: <b>{{$pagos->id}}</b>
                                                                </div>
                                                                <br>
                                                                <a href="../clientes" class="btn btn-outline-dark btn-lg">Volver</a> 
        </div>  
    </div> 

</div> 
                 
                            
        
@endsection