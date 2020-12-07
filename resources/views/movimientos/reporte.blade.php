<style>
    * {
        padding-top: 10px;
        margin-top: 0;
    }
    p, h3{
        text-align: center;
    }
    table{
        width: 100%;
        text-align: center;
        border-collapse: collapse;
    }
    th, td{
        border: 1px solid black;
    }
    .nombre-empresa{
        display: inline-block;
        margin-left: 5cm;
    }
    img{
        margin: auto;
        margin-left: 0.2cm;
    }
</style>
<div>
    <table class="encabezado">
        <tr>
            <td>
                @if(asset('images/' . config('app.logo')))
                    <img src="{{'images/' . config('app.logo')}}" style="width: {{config('app.ancho')}}cm; height: {{config('app.alto')}}cm" />
                @endif
                <h3 class="nombre-empresa">{{config('app.empresa')}}</h3>
            </td>
            <td>
                <p>RUC: {{config('app.ruc')}}</p>
                <p>Telefono: {{config('app.telefono')}}</p>
                <p>Dirección: {{config('app.direccion')}}</p>
            </td>
        </tr>
    </table>


<h3>Reporte de Movimientos</h3>
<p>Filtros: {{null != $filtros -> get('date_ini') ? "Desde: " . $filtros -> get('date_ini') : ""}}
            {{null != $filtros -> get('date_fin') ? "Hasta: " . $filtros -> get('date_fin') : ""}}</p>
<p>{{null != $cat_filtro ? "Categoria:" . $cat_filtro : ""}}</P>

    <table>
                    <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Categoria</th>
                        @if($filtro == 1)
                        <th>Nombre</th>
                        <th>Concepto</th>
                        @endif
                        <th>Ingreso</th>
                        <th>Egreso</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($movimiento as $m)
                            <tr>
                                <td>{{$m -> fecha}}</td>
                                <td>{{$m -> categoria -> nombreCategoria}}</td>
                                @if($filtro == 1)
                                <td>{{$m -> entidad_nombre}}</td>
                                <td>{{$m -> concepto}}</td>
                                @endif
                                <td>{{number_format($m -> ingreso)}}</td>
                                <td>{{number_format($m -> egreso)}}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="{{!($filtro > 1) ? 4 : 2}}">Totales: </td>
                            <td>{{number_format($totales['ingreso'])}}</td>
                            <td>{{number_format($totales['egreso'])}}</td>
                        </tr>
                        <tr>
                            <td colspan="{{!($filtro > 1) ? 4 : 2}}">Total final: </td>
                            <td colspan="2">{{number_format($totales['ingreso'] - $totales['egreso'])}}</td>
                        </tr>
                    </tbody>
        </table>
</div>
