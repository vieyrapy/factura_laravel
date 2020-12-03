<template>
  <div class="modal fade" id="nuevaCategoria" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nueva Categoría</h5>
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
                                <label for="nombre" class="col-md-4 col-form-label text-md-right">Nombre</label>
                                <div class="col-md-6">
                                    <input v-model="formulario.nombre" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="descripcion" class="col-md-4 col-form-label text-md-right">Descripción</label>
                                <div class="col-md-6">
                                    <input v-model="formulario.descripcion" class="form-control">
                                </div>
                            </div>

                        <div class="modal-footer">
                            <button @click="guardar" class="btn btn-primary">Guardar</button>
                        </div>
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
        nombre: "",
        descripcion: ""
      },
      errors: [],
    };
  },
  methods: {
    guardar() {
      if (
        this.formulario.nombre == ""
      ) {
        this.errors.push("Aún hay campos que deben ser completados");
        return;
      }
      axios.post("/api/categoria", this.formulario).then(()=>{
          axios
            .get("/api/categoria")
            .then((resultado) => (this.$global.categorias_movimiento = resultado.data));
      });
      this.formulario = {
        nombre: "",
        descripcion: ""
      };
      this.errors = [];
      this.$emit("creada-categoria");
      $("#nuevaCategoria").modal("hide");
      $("#nuevoMovimiento").modal("show");
    },
  },
};
</script>
