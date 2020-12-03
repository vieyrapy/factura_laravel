<template>
  <div class="modal" id="proveedor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Selección de Proveedor</h5>
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <button
            class="btn btn-primary"
            data-toggle="modal"
            data-target="#nuevoProveedor"
            @click="cerrar"
          >
            + Crear nuevo Proveedor
          </button>

          <select v-model="$global.proveedor" class="form-control mt-4">
            <option
              v-for="proveedor in $global.proveedores"
              v-bind:key="proveedor.id"
              :value="proveedor"
            >
              {{ proveedor.nombre }}
            </option>
          </select>
        </div>

        <div class="modal-footer">
          <button
            class="btn btn-primary mx-auto"
            :disabled="$global.proveedor == {}"
            data-toggle="modal"
            data-target="#nuevoMovimiento"
            @click="cerrar"
          >
            Seleccionar proveedor
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: () => {
    return {
      proveedors: [],
    };
  },
  mounted() {
    axios
      .get("/api/proveedor")
      .then((resultado) => (this.$global.proveedores = resultado.data));
  },
  methods: {
      cerrar(){
          $("#proveedor").modal("hide");
      }
  },
};
</script>
