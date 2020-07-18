<style>
    h1, p{
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
</style>

<h1>Reporte de Movimientos</h1> 
<p>Filtros: Desde: {{null != $filtros -> get('date_ini') ? $filtros -> get('date_ini') : ""}}{{$filtros -> get('month_ini')}}{{null != $filtros -> get('year_ini') ? date("Y") - ($filtros -> get('year_ini')) : ""}} 
    Hasta: {{null != $filtros -> get('date_fin') ? $filtros -> get('date_fin') : ""}}{{$filtros -> get('month_fin')}}{{null != $filtros -> get('year_fin') ? date("Y") - ($filtros -> get('year_fin')) : ""}}</p>
<p>Categoria: {{$cat_filtro}}</P>

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
                                <td>{{$m -> entidad}}</td>
                                <td>{{$m -> concepto}}</td>
                                @endif
                                <td>{{number_format($m -> ingreso)}}</td>
                                <td>{{number_format($m -> egreso)}}</td>
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