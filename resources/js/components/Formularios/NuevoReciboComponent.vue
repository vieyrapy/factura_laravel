<template>
    <div class="modal" id="nuevoRecibo" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nuevo Recibo</h5>
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
                <select class="form-control" v-model="formulario.cliente_id" @change="buscarPendientes">
                    <option v-for="cliente in $global.clientes" :key="cliente.id" :value="cliente.id">{{cliente.nombre}}</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="factura" class="col-md-4 col-form-label text-md-right">Factura</label>
            <div class="col-md-6">
                <select :disabled="facturas.length < 1" class="form-control" v-model="formulario.factura_id">
                    <option v-for="factura in facturas" :key="factura.id" :value="factura">{{factura.nro_factura != "" ? factura.nro_factura : 'Sin número'}} - {{factura.monto_pendiente}}</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
          <label for="concepto" class="col-md-4 col-form-label text-md-right">Concepto</label>

          <div class="col-md-6">
            <input
              autocomplete="off"
              class="form-control"
              name="concepto"
              v-model="formulario.concepto"
              autofocus
            />
          </div>
        </div>

        <div class="form-group row">
          <label for="total" class="col-md-4 col-form-label text-md-right">Total Pendiente</label>

          <div class="col-md-6">
            <input
              class="form-control"
              autocomplete="off"
              name="total"
              v-model="formulario.factura_id.monto_pendiente"
              autofocus
              disabled
            />
          </div>
        </div>

        <div class="form-group row">
          <label for="entrega" class="col-md-4 col-form-label text-md-right">Entrega</label>

          <div class="col-md-6">
            <input
              class="form-control"
              autocomplete="off"
              name="entrega"
              v-model="formulario.entrega"
              autofocus
            />
          </div>
        </div>

                    <div class="modal-footer">
                        <button @click="guardar()" class="btn btn-primary">Guardar</button>
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
        cliente_id: "",
        factura_id: {
            monto_pendiente: 0
        },
        concepto: "",
        entrega: "",
        saldo: 0,
      },
      facturas: [],
      errors: [],
    };
  },
  mounted() {
    axios
      .get("/api/cliente")
      .then((resultado) => (this.$global.clientes = resultado.data));
  },
  methods: {
    buscarPendientes() {
      axios
        .get("/api/venta/pendientes/" + this.formulario.cliente_id)
        .then((resultado) => {
            this.errors = [];
            this.facturas = resultado.data;
            if(resultado.data < 1){
                this.errors.push("El cliente no tiene facturas pendientes");
                return;
            }})
    },
    numeroConComa(numero) {
      return numero.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },
    guardar() {
        this.errors = [];
      if (
        this.formulario.cliente_id == "" ||
        this.formulario.concepto == "" ||
        this.formulario.entrega == ""
      ) {
        this.errors.push("Aún hay campos que deben ser completados");
        return;
      }
      this.formulario.entrega = this.formulario.entrega.toString().replace(/,/g, "");
      if(this.formulario.entrega > this.formulario.factura_id.monto_pendiente){
          this.errors.push("La entrega no debe superar a la factura seleccionada");
        return;
      }
      axios.post("/api/pago", this.formulario).then((resultado) => {
        axios.post("/api/mail", resultado.data);
      });
      this.formulario = {
       cliente_id: "",
        factura_id: {
            monto_pendiente: 0
        },
        concepto: "",
        entrega: "",
        saldo: 0,
      };
      this.facturas = [];
      this.errors = [];
      this.$emit("pago-registrado");
      $("#nuevoRecibo").modal("hide");
    },
  },
};
</script>
