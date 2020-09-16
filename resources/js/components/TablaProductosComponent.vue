<template>
<div class="col sm">
    <button type="button" class="btn btn-primary" @click="editar()">+ Nuevo Venta</button>
    <table class="table table-hover thead-light text-center">
                    <thead>
                        <th>Producto</th>
                        <th>Stock actual</th>
                        <th>Precio de venta</th>
                        <th>Precio de compra</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody>
                       <tr v-for="producto in productos" :key="producto.id">
                           <td>{{producto.nombre}}</td>
                           <td>{{producto.stock_actual}}</td>
                           <td>{{producto.precio_venta}}</td>
                           <td>{{producto.precio_compra}}</td>
                           <td>
                                <button type="button" class="btn btn-primary" @click="editar(producto)" >Modificar</button>
                                <button type="button" class="btn btn-primary" @click="eliminar(producto.id)">Eliminar</button>
                            </td>
                       </tr>
                    </tbody>
        </table>
        <nav>
            <ul class="pagination">
                <li class="page-item" v-if="pagination.current_page > 1">
                    <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page - 1)">
                        <span>Anterior</span>
                    </a>
                </li>
                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[ page == isActivated ? 'active' : '']">
                    <a class="page-link" href="#" @click.prevent="changePage(page)">
                        {{ page }}
                    </a>
                </li>
                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                    <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page + 1)">
                        <span>Siguiente</span>
                    </a>
                </li>
            </ul>
        </nav>
        <nuevo-producto-component :formulario="productoEditar" @creado-producto="getProductos(pagination.current_page)"></nuevo-producto-component>
        <eliminar-component api="productos" :registro="productoEliminar" @eliminado-producto="getProductos(pagination.current_page)"></eliminar-component>
    </div>
</template>

<script>
    export default {
        data: () => {
            return {
                productos: [],
                productoEditar: {},
                productoEliminar: 0,
                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0
                }
            }
        },
        mounted() {
            this.getProductos(1);
        },
        computed: {
            isActivated() {
                return this.pagination.current_page;
            },
            pagesNumber() {
                if(!this.pagination.to){
                    return [];
                }

                let from = this.pagination.current_page - 2;
                if(from < 1){
                    from = 1;
                }

                let to = from + 2 * 2;
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }

                let pagesArray = [];
                while(from <= to){
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            },
            productoVacio(){
                return {
                    id: null,
                    nombre: null,
                    descripcion: null,
                    stock_actual: null,
                    stock_minimo: null,
                    precio_compra: null,
                    precio_venta: null,
                    categoria_producto_id: null,
                    iva: "0.09"
                }
            }
        },
        methods: {
            getProductos(page) {
                axios.get('/api/productos?page=' + page).then(resultado => {
                    this.productos = resultado.data.productos.data;
                    this.pagination = resultado.data.pagination;
                });
            },
            changePage(page){
                this.pagination.current_page = page;
                this.getProductos(page);
            },
            editar(producto = this.productoVacio){
                this.productoEditar = Object.assign({}, producto);
                $('#nuevoProducto').modal('show');
            },
            eliminar(id){
                this.productoEliminar = id;
                $('#eliminar').modal('show');
            }
        }
    }
</script>
