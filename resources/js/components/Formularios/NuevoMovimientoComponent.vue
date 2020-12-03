<template>
  <div class="modal fade" id="nuevoMovimiento" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title movimiento">Nuevo Movimiento</h5>
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

                            <div hidden>
                                <input id="id" type="number" name="id">
                            </div>

                            <div class="form-group row">
                                <label for="fecha" class="col-md-4 col-form-label text-md-right">Fecha</label>
                                <div class="col-md-6">
                                    <input v-model="formulario.fecha" name="fecha" type="date" class="form-control" :max="fechaActual">
                                </div>
                            </div>

                            <div class="form-group row">
                            <label for="nombre" class="col-md-4 col-form-label text-md-right">Proveedor</label>
                            <div class="col-md-6">
                                <input v-model="$global.proveedor.nombre" name="nombre" class="form-control" disabled>
                            </div>
                        </div>

                            <div class="form-group row">
                                <label for="categoria" class="col-md-4 col-form-label text-md-right">Categoria</label>
                                <div class="col-md-6">
                                    <select name="categoria" v-model="formulario.categoria_id" class="form-control d-inline-block w-75">
                                        <option v-for="categoria in $global.categorias_movimiento" :key="categoria.id" :value="categoria.id">{{categoria.nombreCategoria}}</option>
                                    </select>
                                    <button
                                    @click="nuevaCategoria"
      class="btn btn-primary ml-3"
    >
      +
    </button>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="concepto" class="col-md-4 col-form-label text-md-right">Concepto</label>
                                <div class="col-md-6">
                                    <input v-model="formulario.concepto" class="form-control" name="concepto">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Tipo de movimiento</label>
                                    <div class="col-3 align-self-center text-center">
                                        <input type="radio" v-model="formulario.tipo_movimiento" name="ingreso" value="Ingreso"><label for="ingreso">&nbsp Ingreso</label>
                                    </div>
                                    <div class="col-3 align-self-center text-center">
                                        <input type="radio" v-model="formulario.tipo_movimiento" name="egreso" value="Egreso"><label for="egreso">&nbsp Egreso</label>
                                    </div>
                            </div>

                            <div class="form-group row">
                                <label for="monto" class="col-md-4 col-form-label text-md-right">Monto</label>
                                <div class="col-md-6">
                                    <input v-model="formulario.monto" class="form-control" name="monto" @keyup="formulario.monto = numeroConComa(formulario.monto)">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button @click="guardar" class="btn btn-primary">Guardar</button>
                        </div>
                </div>
            </div>
        </div>
</template>

<script>
export default {
  props: {
    formulario: {
      default: {
        fecha: new Date(),
        entidad: "",
        categoria_id: "",
        concepto: "",
        tipo_movimiento: 1,
        monto: "",
      },
    },
  },
  data: () => {
    return {
      categorias: [],
      errors: [],
    };
  },
  mounted() {
    this.formulario.fecha = this.fechaActual;
    axios
        .get("/api/categoria")
        .then((resultado) => (this.$global.categorias_movimiento = resultado.data));
  },
  computed: {
    fechaActual() {
      const fecha = new Date();
      let mes = fecha.getMonth() + 1;
      let dia = fecha.getDate();
      const ano = fecha.getFullYear();
      if (dia.toString().length == 1) dia = "0" + dia;
      if (mes.toString().length == 1) mes = "0" + mes;
      return ano + "-" + mes + "-" + dia;
    },
  },
  methods: {
    numeroConComa(numero) {
      return numero
        .toString()
        .replace(/,/g, "")
        .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },
    guardar() {
      this.errors = [];
      if (
        this.formulario.concepto == "" ||
        this.formulario.categoria_id == "" ||
        !(this.formulario.monto.toString().replace(/,/g, "") > 0)
      ) {
        this.errors.push("Aún hay campos que deben ser completados");
        return;
      }
      this.formulario.entidad = this.$global.proveedor.id;
      axios.post("/api/movimiento", this.formulario);
      this.errors = [];
      $("#nuevoMovimiento").modal("hide");
      this.$emit("creado-movimiento");
    },
    nuevoProveedor() {
      $("#nuevoMovimiento").modal("hide");
      $("#nuevoProveedor").modal("show");
    },
    nuevaCategoria(){
        $("#nuevoMovimiento").modal("hide");
      $("#nuevaCategoria").modal("show");
    }
  },
};
</script>
