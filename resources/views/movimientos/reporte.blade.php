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
<p>Filtros: Desde {{null != $filtros -> get('date_ini') ? date_format(new DateTime($filtros -> get('date_ini')), 'd/m/Y') : ""}}{{$filtros -> get('month_ini')}}{{$filtros -> get('year_ini')}} 
    Hasta: {{null != $filtros -> get('date_ini') ? date_format(new DateTime($filtros -> get('date_ini')), 'd/m/Y') : ""}}{{$filtros -> get('month_fin')}}{{$filtros -> get('year_fin')}}</p>

<table>
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
    </tbody>
</table>