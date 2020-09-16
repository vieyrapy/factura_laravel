
    <table cellspacing="0" cellpadding="0" width="100%" bgcolor="#f0f0f0" align="center">
    <tbody><tr width="100%" align="center">
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
    <tbody><tr>
        <td style="height:60px" align="center"></td>
    </tr>
    <tr>
        <td width="420px" style="color:#ff7800;font-size:60px;font-family:'Lato-Light',Lato,sans-serif;line-height:55px" align="center" valign="middle">
            Gracias por tu preferencia
        </td>
    </tr>
    <tr>
        <td style="height:40px" align="center"></td>
    </tr>
    <tr align="center">
        <td style="color:#4a4a4a;font-size:18px;font-family:'Lato-Regular',Lato,sans-serif" align="center" width="351px" valign="middle">
            <b>{{$nombre}}</b>, a continuación se presentan los detalles de su compra.<br><br>
        </td>
    </tr>
    <tr>
        <td style="height:45px" align="center"></td>
    </tr>
    <tr>
        <td>
            <table width="100%">
                <tbody><tr>


                    <td valign="top">
                        <table width="100%">
                            <tbody>
                            <tr>

                                <td valign="top">
                                    <table width="100%" cellspacing="0" cellpadding="0">
                                        <tbody><tr>
                                            <td style="font-family:'Lato-Light',Lato,sans-serif;font-size:20px;color:#4a4a4a">
                                                {{date_format($fecha, 'd/m/Y')}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="color:#9b9b9b;font-size:12px;text-align:left;font-family:'Lato-Regular',Lato,sans-serif">
                                                Fecha de compra
                                            </td>
                                        </tr>
                                        <tr>
                                        <td height="9px"></td>
                                        </tr>
                                        <tr width="100%">
                                        <table width="100%">
                                            <tr>
                                                <td style="font-size:25px;font-family:'Lato-Light',Lato,sans-serif; width: 33%">Producto</td>
                                                <td style="font-size:25px;font-family:'Lato-Light',Lato,sans-serif;width: 33%">Cantidad</td>
                                                <td style="font-size:25px;font-family:'Lato-Light',Lato,sans-serif;width: 33%">Precio</td>
                                            </tr>
                                        @foreach($detalles as $detalle)
                                            <tr>
                                                <td style="font-size:18px;font-family:'Lato-Light',Lato,sans-serif;width: 33%">{{$detalle->producto_id}}</td>
                                                <td style="font-size:18px;font-family:'Lato-Light',Lato,sans-serif;width: 33%">{{number_format($detalle->cantidad, 0, ',', '.')}}</td>
                                                <td style="font-size:18px;font-family:'Lato-Light',Lato,sans-serif;width: 33%">{{number_format($detalle->valor_venta, 0, ',', '.')}}</td>
                                            </tr>
                                        @endforeach
                                        </table>
                                        </tr>
                                        <tr>
                                            <td height="8px"></td>
                                        </tr>
                                        <tr>
                                            <td style="color:#003278;font-size:40px;font-family:'Lato-Regular',Lato,sans-serif;font-weight:900">
                                                <b>Gs. {{number_format($total, 0, ',', '.')}}</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-family:'Lato-Regular',Lato,sans-serif;font-size:12px;font-weight:900;color:#4a4a4a">
                                                TOTAL
                                            </td>
                                        </tr>
                                    </tbody></table>
                                </td>
                            </tr>
                        </tbody></table>
                    </td>
                </tr>
            </tbody></table>
        </td>
    </tr>
    <tr>
        <td style="height:69px" align="center"></td>
    </tr>
</tbody></table>
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
</tbody></table>
