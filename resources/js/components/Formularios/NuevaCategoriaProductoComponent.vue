<template>
  <div
    class="modal fade"
    id="nuevaCategoriaProducto"
    tabindex="-1"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Nueva Categoría</h5>
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group row">
            <label for="categoria" class="col-md-4 col-form-label text-md-right"
              >Nombre</label
            >
            <div class="col-md-6">
              <input
                v-model="formulario.categoria"
                name="categoria"
                class="form-control"
              />
            </div>
          </div>

          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" @click="guardar">
              Guardar
            </button>
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
        categoria: "",
      },
    };
  },
  methods: {
    guardar() {
      axios.post("/api/categoria-producto", this.formulario);
      axios
        .get("/api/categoria-producto")
        .then((resultado) => (this.$global.categorias = resultado.data));
      $("#nuevaCategoriaProducto").modal("hide");
    },
  },
};
</script>
