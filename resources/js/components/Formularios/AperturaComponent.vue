<template>
  <div id="apertura" class="modal" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5>Apertura de caja</h5>
        </div>
        <div class="modal-body">
          <div class="form-group row">
            <label for="monto" class="col-md-4 col-form-label text-md-right"
              >Monto actual en caja</label
            >
            <div class="col-md-6">
              <input type="number" v-model="monto" class="form-control" />
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button
            type="submit"
            class="btn btn-primary"
            data-dismiss="modal"
            @click="guardar()"
          >
            Iniciar venta
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    props: ['mostrar'],
   data: () => {
    return {
      monto: ""
    };
  },
  mounted() {
      if(this.mostrar){
          $('#apertura').modal({backdrop: 'static', keyboard: false});
      }
  },
  methods: {
    guardar() {
      axios
        .post("/api/caja/apertura", {'monto': this.monto})
        .then(resultado => {
            if(resultado.data){
                console.log("Apertura registrada");
                $("#apertura").hide();
            }
        });
    },
  },
};
</script>
