<style>
    * {
        margin: 0;
        padding: 0;
        position: fixed;
    }
    .fecha {
        top: 4.5cm;
        left: 5cm;
    }
    .condicion {
        top: 4.5cm;
        left: {{$condicion == "Contado" ? "15.5cm" : "18cm"}}
    }
    .nombre {
        top: 5cm;
        left: 6cm;
    }
    .ruc {
        top: 5.5cm;
        left: 2.5cm;
    }
    .telefono {
        top: 5.5cm;
        left: 16cm;
    }
    .direccion {
        top: 6cm;
        left: 4cm;
    }
    .total-letras {
        top: 13cm;
        left: 5cm;
    }
    .total {
        top: 13cm;
        left: 16cm;
    }
    .total-iva {
        top: 13.5cm;
        left: 16cm;
    }
    .iva5-total {
        top: 13.5cm;
        left: 4.5cm
    }
    .iva10-total {
        top: 13.5cm;
        left: 10.5cm
    }
    .tabla {
        top: 7cm;
        left: 1.5cm;
    }
    .tabla td {
        height: 0.5cm;
    }
    .cantidad {
        width:1.5cm;
        text-align: right;
    }
    .producto {
        width: 8cm;
    }
    .precio {
        width: 2cm;
    }
    .exentas {
        width: 2cm;
        text-align: right;
    }
    .iva5 {
        width: 2.5cm;
        text-align: right;
    }
    .iva10 {
        width: 2.5cm;
        text-align: right;
    }
</style>
<div>
    <p class="fecha">{{date_format($fecha, 'd/m/Y')}}</p>
    <p class="condicion">X</p>
    <p class="nombre">{{$nombre}}</p>
    <p class="ruc">{{$ruc}}</p>
    <p class="telefono">{{$telefono}}</p>
    <p class="direccion">{{$direccion}}</p>
    <p class="total-letras">{{$total_letras}}</p>
    <p class="total">{{$total}}</p>
    <p class="total-iva">{{$total_iva}}</p>
    <p class="iva5-total">{{$iva5}}</p>
    <p class="iva10-total">{{$iva10}}</p>
    <table class="tabla">
        @foreach($detalles as $detalle)
            <tr>
                <td class="cantidad">{{$detalle['cantidad']}}</td>
                <td class="producto">{{$detalle['producto']['nombre']}}</td>
                <td class="precio">{{$detalle['producto']['precio_venta']}}</td>
                <td class="exentas">{{$detalle['producto']['iva'] == 0 ? $detalle['valor_venta'] : 0}}</td>
                <td class="iva5">{{$detalle['producto']['iva'] == 21 ? $detalle['valor_venta'] : 0}}</td>
                <td class="iva10">{{$detalle['producto']['iva'] == 11 ? $detalle['valor_venta'] : 0}}</td>
            </tr>
        @endforeach
    </table>
</div>
