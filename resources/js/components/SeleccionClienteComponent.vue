<template>
  <div class="modal" id="cliente" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Selección de Cliente</h5>
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <button
            class="btn btn-primary"
            data-toggle="modal"
            data-target="#nuevoCliente"
          >
            + Crear nuevo cliente
          </button>

          <select v-model="$global.cliente" class="form-control mt-4">
            <option
              v-for="cliente in $global.clientes"
              v-bind:key="cliente.id"
              :value="cliente"
            >
              {{ cliente.nombres }}
            </option>
          </select>
        </div>

        <div class="modal-footer">
          <button
            class="btn btn-primary"
            :disabled="!$global.cliente.id"
            @click="seleccionar"
          >
            Seleccionar cliente
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
      clientes: [],
    };
  },
  mounted() {
    axios
      .get("/api/cliente")
      .then((resultado) => (this.$global.clientes = resultado.data));
  },
  methods: {
      seleccionar(){
          $("#cliente").modal("hide");
      $("#nuevaVenta").modal("show");
      }
  },
};
</script>
