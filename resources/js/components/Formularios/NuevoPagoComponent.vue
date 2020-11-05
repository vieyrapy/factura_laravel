<template>
  <div class="col-sm">
    <div class="card">
      <div class="card-body">
          <button class="btn btn-primary mb-5 mt-2 ml-2" data-toggle="modal" data-target="#nuevoCliente">+ Crear nuevo cliente</button>
            <p v-if="errors.length">
                <b>Por favor, corrija el(los) siguiente(s) error(es):</b>
                <ul>
                    <li v-for="error in errors" :key="error">{{ error }}</li>
                </ul>
            </p>
        <div class="form-group row">
            <label for="nombre" class="col-md-4 col-form-label text-md-right">Nombre</label>

            <div class="col-md-6">
                <select class="form-control" v-model="formulario.cliente_id">
                    <option v-for="cliente in $global.clientes" :key="cliente.id" :value="cliente.id">{{cliente.nombre}}</option>
                </select>
            </div>
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
          <label for="total" class="col-md-4 col-form-label text-md-right">Total</label>

          <div class="col-md-6">
            <input
              @keyup="calcular"
              class="form-control"
              autocomplete="off"
              name="total"
              v-model="formulario.total"
              autofocus
            />
          </div>
        </div>

        <div class="form-group row">
          <label for="entrega" class="col-md-4 col-form-label text-md-right" @keyup="calcular">Entrega</label>

          <div class="col-md-6">
            <input
              @keyup="calcular"
              class="form-control"
              autocomplete="off"
              name="entrega"
              v-model="formulario.entrega"
              autofocus
            />
          </div>
        </div>

        <div class="form-group row">
          <label for="saldo" class="col-md-4 col-form-label text-md-right">Saldo</label>

          <div class="col-md-6">
            <input
              class="form-control"
              name="saldo"
              v-model="formulario.saldo"
              autofocus
              readonly
            />
          </div>
        </div>

        <div class="form-group row mb-0">
          <div class="col-md-6 offset-md-4">
            <button
              class="btn btn-outline-dark btn-lm mb-5"
              @click="guardar"
            >Guardar y enviar</button>
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
        concepto: "",
        total: "",
        entrega: "",
        saldo: 0,
      },
      errors: [],
    };
  },
  mounted() {
    axios
      .get("/api/cliente")
      .then((resultado) => (this.$global.clientes = resultado.data));
  },
  methods: {
    calcular() {
      const total = this.formulario.total.replace(/,/g, "");
      const entrega = this.formulario.entrega.replace(/,/g, "");
      this.formulario.saldo = this.numeroConComa(total - entrega);
      this.formulario.total = this.numeroConComa(total);
      this.formulario.entrega = this.numeroConComa(entrega);
    },
    numeroConComa(numero) {
      return numero.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },
    guardar() {
      if (
        this.formulario.cliente_id == "" ||
        this.formulario.concepto == "" ||
        this.formulario.total == "" ||
        this.formulario.entrega == ""
      ) {
        this.errors.push("Aún hay campos que deben ser completados");
        return;
      }
      if (this.formulario.saldo == NaN) {
        this.errors.push("Los campos Saldo y Entrega deben ser numéricos");
        return;
      }
      const total = this.formulario.total.replace(/,/g, "");
      const entrega = this.formulario.entrega.replace(/,/g, "");
      if (parseInt(total) < parseInt(entrega)) {
        this.errors.push("La entrega no debe ser mayor al total");
        return;
      }
      this.formulario.total = total;
      this.formulario.entrega = entrega;
      this.formulario.saldo = total - entrega;
      axios.post("/api/pago", this.formulario).then((resultado) => {
        axios.post("/api/mail", resultado.data);
      });
      this.formulario = {
        cliente_id: "",
        concepto: "",
        total: "",
        entrega: "",
        saldo: 0,
      };
      this.errors = [];
      this.$emit("pago-registrado");
    },
  },
};
</script>
