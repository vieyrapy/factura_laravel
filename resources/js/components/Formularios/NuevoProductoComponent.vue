<template>
    <div class="modal" id="nuevoProducto" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title producto">{{ formulario.id ? "Editar" : "Nuevo" }} Producto</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                        <div class="modal-body">

                            <button type="button" class="btn btn-primary mb-2" @click="nuevaCategoria()">
                                + Nueva Categoria
                            </button>

                            <p v-if="errors.length">
                                <b>Por favor, corrija el(los) siguiente(s) error(es):</b>
                                <ul>
                                <li v-for="error in errors" :key="error">{{ error }}</li>
                                </ul>
                            </p>

                            <div hidden>
                                <input v-model="formulario.id">
                            </div>

                            <div class="form-group row">
                                <label for="categoria" class="col-md-4 col-form-label text-md-right">Categoria</label>
                                <div class="col-md-6">
                                    <select class="form-control" v-model="formulario.categoria_producto_id">
                                        <option v-for="categoria in $global.categorias_producto" :key="categoria.id" :value="categoria.id">{{categoria.nombre}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="nombre" class="col-md-4 col-form-label text-md-right">Nombre del Producto</label>
                                <div class="col-md-6">
                                    <input class="form-control" v-model="formulario.nombre" autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="descripcion" class="col-md-4 col-form-label text-md-right">Descripción</label>
                                <div class="col-md-6">
                                    <input v-model="formulario.descripcion" class="form-control" autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="stock_actual" class="col-md-4 col-form-label text-md-right">Stock Actual</label>
                                <div class="col-md-6">
                                    <input class="form-control" v-model="formulario.stock_actual" autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="stock_minimo" class="col-md-4 col-form-label text-md-right">Stock Minimo</label>
                                <div class="col-md-6">
                                    <input class="form-control" v-model="formulario.stock_minimo" autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="precio_venta" class="col-md-4 col-form-label text-md-right">Precio de Venta</label>
                                <div class="col-md-6">
                                    <input class="form-control" v-model="formulario.precio_venta" autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="precio_compra" class="col-md-4 col-form-label text-md-right">Precio de Compra</label>
                                <div class="col-md-6">
                                    <input class="form-control" v-model="formulario.precio_compra" autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">IVA</label>
                                <div class="col-3 align-self-center text-center">
                                    <input type="radio" id="iva10" name="iva" value="11" v-model="formulario.iva" ><label for="iva10">IVA 10</label>
                                </div>
                                <div class="col-3 align-self-center text-center">
                                    <input type="radio" id="iva5" name="iva" value="21" v-model="formulario.iva"><label for="iva5">IVA 5</label>
                                </div>
                                <div class="col-3 align-self-center text-center">
                                    <input type="radio" id="exenta" name="iva" value="0" v-model="formulario.iva"><label for="exenta">Exenta</label>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" value="submit" @click="guardar()">Guardar</button>
                        </div>
                </div>
            </div>
        </div>
</template>

<script>
export default {
  data: () => {
    return {
      errors: [],
      categorias: [],
      formulario: {
        id: null,
        nombre: null,
        descripcion: null,
        stock_actual: null,
        stock_minimo: null,
        precio_compra: null,
        precio_venta: null,
        categoria_producto_id: null,
        iva: "11",
    },
    };
  },
  mounted(){
      axios
        .get("/api/categoria-producto")
        .then((resultado) => (this.$global.categorias_producto = resultado.data));
  },
  methods: {
    guardar() {
      if (
        !(
          this.formulario.nombre ||
          this.formulario.stock_actual ||
          this.formulario.stock_minimo ||
          this.formulario.precio_compra ||
          this.formulario.precio_venta ||
          this.formulario.categoria_producto_id
        )
      ) {
        errors.push("Aún hay campos que deben ser completados");
        return;
      }
      if (this.formulario.id) {
        console.log(this.formulario.id);
        axios.put("/api/producto/" + this.formulario.id, this.formulario);
      } else {
        axios.post("/api/producto", this.formulario);
      }
      axios
        .get("/api/producto-seleccion")
        .then((resultado) => (this.$global.productos = resultado.data));
      $("#nuevoProducto").modal("hide");
      $("#nuevaVenta").modal("show");
    },
    nuevaCategoria(){
      $("#nuevoProducto").modal("hide");
      $("#nuevaCategoriaProducto").modal("show");
  }
  },
};
</script>
