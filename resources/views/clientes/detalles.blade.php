
@extends('layouts.app')

@section('content') 
   
     <table cellspacing="0" cellpadding="0" width="100%" bgcolor="#f0f0f0" align="center">
    
    <tbody>

      <tr width="100%" align="center">
        <td width="100%" align="center">
            <table cellspacing="0" cellpadding="0" width="600px">
                <tbody><tr>
                    <td style="height:61px" align="center">
                        
                    </td>
                </tr>
                <tr>
                    <td style="background-color:#ffffff" align="left" valign="middle">
                        <a href="#m_-6108734568478989486_">
                            <img src="http://rocemi.com.py/wp-content/uploads/2019/03/sds-nav-emails.jpg" width="600px" border="0" alt="Studio Sanchez" align="center" class="CToWUd">
                        </a>

                    </td>
                </tr>
                <tr>
                    <td style="background-color:#ffffff;font-family:'Lato-Regular','Lato',Calibri,sans-serif!important" align="center" valign="middle">

 
    <table cellspacing="0" cellpadding="0" width="420px" bgcolor="#ffffff">
    <tbody>
        
        <tr>
            <td style="height:60px" align="center"></td>
        </tr>

        <tr>
            <td width="420px" style="color:#ff7800;font-size:60px;font-family:'Lato-Light',Lato,sans-serif;line-height:55px" align="center" valign="middle">
             
            </td>
        </tr>

        <tr>
            <td style="height:40px" align="center"></td>
        </tr>

        <tr align="center">
            <td style="color:#4a4a4a;font-size:18px;font-family:'Lato-Regular',Lato,sans-serif" align="center" width="351px" valign="middle">
                <b>{{$clientes->nombre}}</b>, acontinuación se detalla el pago realizado por: <b>{{$pagos->concepto}}</b>.<br><br>
                        <form method="POST" action="{{ route('pdf')}}"> 
                            @csrf

                            <div class="form-group row">
                                
                                <div class="col-md-6" hidden>
                                    <input id="id_pago" type="text" class="form-control" name="id_pago" value="{{$pagos->id}}" required autofocus>
                                
                                </div>
                            </div>

                            <div class="form-group row mb-0" >
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-outline-dark btn-lg">
                                        {{ __('Descargar recibo') }}
                                    </button>
                                </div>
                            </div>
                        </form>
            </td>
        </tr>

        <tr>
            <td style="height:45px" align="center"></td>
        </tr>
        <tr>
            <td>
                <table>
                    <tbody>
                        <tr>
                            <td valign="top">
                                <table>
                                    <tbody>
                                    <tr>
                                      
                                        <td valign="top">
                                            <table width="100%" cellspacing="0" cellpadding="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="font-family:'Lato-Light',Lato,sans-serif;font-size:20px;color:#4a4a4a">
                                                            {{date_format($pagos->created_at, 'd/m/Y')}}
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td style="color:#9b9b9b;font-size:12px;text-align:left;font-family:'Lato-Regular',Lato,sans-serif">
                                                            Fecha de pago
                                                        
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td height="9px"></td>
                                                    </tr>
                                        
                                                    <tr>
                                                        <td height="8px"></td>
                                                    </tr>

                                                    <tr>
                                                        <td style="color:#003278;font-size:40px;font-family:'Lato-Regular',Lato,sans-serif;font-weight:900">
                                                            <b>Gs. {{number_format($pagos->entrega, 0, ',', '.')}}</b>
                                                        </td>

                                                    </tr>

                                                    <tr>
                                                        <td style="font-family:'Lato-Regular',Lato,sans-serif;font-size:12px;font-weight:900;color:#4a4a4a">
                                                            PAGO REALIZADO
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td height="9px"></td>
                                                    </tr>
                                            
                                                    <tr>
                                                        <td height="8px"></td>
                                                    </tr>
                                               
                                                     <tr>
                                                        <td style="font-family:'Lato-Light',Lato,sans-serif;font-size:30px;color:#4a4a4a">
                                                            <b>Gs. {{number_format($pagos->total, 0, ',', '.')}}</b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-family:'Lato-Regular',Lato,sans-serif;font-size:12px;font-weight:900;color:#4a4a4a">
                                                            DEUDA TOTAL
                                                        </td>
                                                    </tr>
                                                   
                                                    <tr>
                                                        <td height="9px"></td>
                                                    </tr>
                                            
                                                    <tr>
                                                        <td height="8px"></td>
                                                    </tr>
                                                     <tr>
                                                        <td style="font-family:'Lato-Light',Lato,sans-serif;font-size:30px;color:#ff7800">
                                                            <b>Gs. {{number_format($pagos->saldo, 0, ',', '.')}}</b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-family:'Lato-Regular',Lato,sans-serif;font-size:12px;font-weight:900;color:#4a4a4a">
                                                            SALDO 
                                                        </td>
                                                    </tr>
                                                
                                                    <tr>
                                                        <td style="font-family:'Lato-Regular',Lato,sans-serif;font-size:14px;font-weight:900;color:#4a4a4a">
                                                            <br>
                                                            <br>
                                                            TELEFONO: <b>{{$clientes->telefono}}</b> 
                                                            <br>
                                                            E-MAIL: <b>{{$clientes->email}}</b>
                                                            <br>
                                                            ID: <b>{{$pagos->id}}</b>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>

        <tr>
            <td style="height:69px" align="center"></td>
        </tr>
</tbody>
</table>
                    </td>
                </tr>
                <tr>
                    <td style="background-color:#f4f4f4;font-family:'Lato-Regular','Lato',Calibri,sans-serif!important" align="left" valign="middle" height="145px">
                        <table>
                            <tbody><tr>
                                <td width="73px"></td>
                                <td>
                                    <img src="http://rocemi.com.py/wp-content/uploads/2019/03/sds.png" width="61px" border="0" alt="Studio Sanchez" align="center" class="CToWUd">
                                </td>
                                <td width="120px"></td>
                                <td width="117px" style="color:#545353;font-size:12px" align="center">Si tenés alguna
                                    duda,
                                    escribinos a <b><a href="mailto:sanchezdigital1520@hotmail.com" style="color:#545353" target="_blank">sanchezdigital1520@hotmail.com</a></b>
                                </td>
                                <td width="48px"></td>
                                <td><a href="https://www.facebook.com/studiosanchez" target="_blank"><img src="http://rocemi.com.py/wp-content/uploads/2019/03/fb.png" width="8px" class="CToWUd"></a></td>
                                <td width="32px"></td>
                               
                                <td><a href="https://www.instagram.com/studiosanchezpy/" target="_blank"><img src="http://rocemi.com.py/wp-content/uploads/2019/03/inst.png" width="15px" class="CToWUd"></a></td>
                            </tr>
                        </tbody></table>
                    </td>
                </tr>
                <tr><td align="center" style="font-family:'Lato-Regular','Lato',Calibri,sans-serif!important;color:#545353">Este es un correo electrónico automatizado del sistema. Por favor no responder a este email.</td></tr>
            </tbody></table>
        </td>
    </tr>
</tbody>
</table>

               
@endsection