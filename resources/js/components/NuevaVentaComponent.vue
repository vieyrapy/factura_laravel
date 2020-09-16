<template>
    <div class="modal" id="nuevaVenta" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Venta</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                    <div class="modal-body">

                        <p v-if="errors.length">
                            <b>Por favor, corrija el(los) siguiente(s) error(es):</b>
                            <ul>
                            <li v-for="error in errors" :key="error">{{ error }}</li>
                            </ul>
                        </p>

                        <div class="form-group row">
                            <label for="factura" class="col-md-4 col-form-label text-md-right">Número de Factura</label>
                            <div class="col-md-6">
                                <input v-model="formulario.factura" name="factura" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nombre" class="col-md-4 col-form-label text-md-right">Cliente</label>
                            <div class="col-md-6">
                                <input v-model="$global.cliente.nombre" name="nombre" class="form-control" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Condición de venta</label>
                            <div class="col-3 align-self-center text-center">
                                <input type="radio" id="contado" name="tipo" value="Contado" v-model="formulario.condicion"><label for="ingreso">Contado</label>
                            </div>
                            <div class="col-3 align-self-center text-center">
                                <input type="radio" id="credito" name="tipo" value="credito" v-model="formulario.condicion"><label for="egreso">Crédito</label>
                            </div>
                        </div>

                        <div class="productos">
                            <table class="table table-light">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Stock Actual</th>
                                        <th>Cantidad</th>
                                        <th>Precio unitario</th>
                                        <th>Precio total</th>
                                        <th>IVA Total</th>
                                        <th><button @click="addDetalle()">+</button></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(detalle, index) in formulario.detalles" :key="detalle.id">
                                        <td>
                                            <select v-model="formulario.detalles[index].producto" class="form-control mt-4">
                                                <option v-for="producto in productos" :key="producto.id" :value="producto">{{producto.nombre}}</option>
                                            </select>
                                        </td>
                                         <td>
                                            <input v-model="formulario.detalles[index].producto.stock_actual" class="form-control" disabled>
                                        </td>
                                        <td>
                                            <input v-model="formulario.detalles[index].cantidad" @keyup="calcularTotales(index)" class="form-control" autofocus>
                                        </td>
                                        <td>
                                            <input v-model="formulario.detalles[index].producto.precio_venta" class="form-control" disabled>
                                        </td>
                                        <td>
                                            <input v-model="formulario.detalles[index].precio_total" class="form-control" disabled>
                                        </td>
                                        <td>
                                            <input v-model="formulario.detalles[index].iva_total" class="form-control" disabled>
                                        </td>
                                        <td><button @click="removeDetalle(index)">-</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="modal-footer d-flex">
                        <button class="btn btn-primary mx-auto" @click="facturar()">Generar factura</button>
                    </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: () => {
            return {
                formulario: {
                    factura: null,
                    cliente: null,
                    condicion: "Contado",
                    detalles: [{producto: '', cantidad: '', precio_total: '', iva_total: ''}],
                    total: 0,
                    total_iva: 0
                },
                productos: {},
                errors: []
            }
        },
        mounted() {
            axios.get('/api/productos/seleccion').then(resultado => this.productos = resultado.data);

        },
        methods: {
            addDetalle(){
                this.formulario.detalles.push({producto: '', cantidad: 0, precio_total: 0, iva_total: 0});
            },
            removeDetalle(index){
                if(this.formulario.detalles.length != 1){
                    this.formulario.detalles.splice(index, 1);
                }
            },
            calcularTotales(index){
                const detalle = this.formulario.detalles[index];
                detalle.precio_total = detalle.cantidad * detalle.producto.precio_venta;
                detalle.iva_total = detalle.precio_total * detalle.producto.iva;
            },
            facturar(){
                this.errors = [];
                this.formulario.cliente = this.$global.cliente.id;
                for(const detalle of this.formulario.detalles){
                    if(!detalle.producto){
                        this.errors.push('No deben permanecer detalles en blanco');
                        return;
                    }
                    if(detalle.producto.stock_actual < detalle.cantidad){
                        this.errors.push('La cantidad del producto "' + detalle.producto.nombre + '" supera al stock actual');
                        return;
                    }
                    detalle.producto = detalle.producto.id;
                    this.formulario.total += detalle.precio_total;
                    this.formulario.total_iva += detalle.iva_total;
                }
                axios.post('/api/ventas', this.formulario).then(console.log('Venta generada'));
                this.$emit('venta-creada');
                $("#nuevaVenta").modal('hide');
                $("#cliente").modal('hide');
                this.formulario = {
                    factura: null,
                    cliente: null,
                    condicion: "Contado",
                    detalles: [{producto: '', cantidad: '', precio_total: '', iva_total: ''}],
                    total: 0,
                    total_iva: 0
                };
            }
        }
    }
</script>
