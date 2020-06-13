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
<p>Filtros: Desde {{null != $filtros -> get('date_ini') ? date_format(new DateTime($filtros -> get('date_ini')), 'd/m/Y') : ""}}{{$filtros -> get('month_ini')}}{{null != $filtros -> get('year_ini') ? date("Y") - ($filtros -> get('year_ini')) : ""}} 
    Hasta: {{null != $filtros -> get('date_fin') ? date_format(new DateTime($filtros -> get('date_fin')), 'd/m/Y') : ""}}{{$filtros -> get('month_fin')}}{{null != $filtros -> get('year_fin') ? date("Y") - ($filtros -> get('year_fin')) : ""}}</p>
<p>Categoria: {{$cat_filtro}}</P>

    <table>
            @switch($filtro)
                @case(2)
                    <thead>
                    <tr>
                        <th>Mes</th>
                        <th>Categoria</th>
                        <th>Ingreso</th>
                        <th>Egreso</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($movimiento as $m)
                            <tr>
                                <td>{{date_format(new DateTime($m -> month), 'm-Y')}}</td>
                                <td>{{$m -> categoria -> nombreCategoria}}</td>
                                <td>{{number_format($m -> ingreso)}}</td>
                                <td>{{number_format($m -> egreso)}}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="2">Totales: </td>
                            <td>{{number_format($totales[0])}}</td>
                            <td>{{number_format($totales[1])}}</td>
                        </tr>
                        <tr>
                            <td colspan="2">Total final: </td>
                            <td colspan="2">{{number_format($totales[0] - $totales[1])}}</td>
                        </tr>
                    </tbody>
                @break
                @case(3)
                <thead>
                <tr>
                        <th>Año</th>
                        <th>Categoria</th>
                        <th>Ingreso</th>
                        <th>Egreso</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($movimiento as $m)
                            <tr>
                                <td>{{$m -> year}}</td>
                                <td>{{$m -> categoria -> nombreCategoria}}</td>
                                <td>{{number_format($m -> ingreso)}}</td>
                                <td>{{number_format($m -> egreso)}}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="2">Totales: </td>
                            <td>{{number_format($totales[0])}}</td>
                            <td>{{number_format($totales[1])}}</td>
                        </tr>
                        <tr>
                            <td colspan="2">Total final: </td>
                            <td colspan="2">{{number_format($totales[0] - $totales[1])}}</td>
                        </tr>
                    </tbody>
                    @break
                    @default
                    <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Nombre</th>
                        <th>Categoria</th>
                        <th>Concepto</th>
                        <th>Ingreso</th>
                        <th>Egreso</th>
                        </tr>
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
                @break
            @endswitch
        </table>