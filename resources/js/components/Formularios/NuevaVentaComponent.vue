<template>
    <div class="modal" id="nuevaVenta" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Venta</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                    <div class="modal-body">

                        <button type="button" class="btn btn-primary mb-2" @click="nuevoProducto()">
                            + Nuevo Producto
                        </button>

                        <p v-if="errors.length">
                            <b>Por favor, corrija el(los) siguiente(s) error(es):</b>
                            <ul>
                            <li v-for="error in errors" :key="error">{{ error }}</li>
                            </ul>
                        </p>

                        <div class="form-group row ml-5">
                            <label for="factura" class="col-md-3 col-form-label">Número de Factura</label>
                            <div class="col-md-6">
                                <input v-model="formulario.factura" name="factura" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row ml-5">
                            <label for="nombre" class="col-md-3 col-form-label">Cliente</label>
                            <div class="col-md-6">
                                <input v-model="$global.cliente.nombres" name="nombre" class="form-control" disabled>
                            </div>
                        </div>

                        <div class="form-group row ml-3">
                            <label for="forma_pago" class="col-md-2 col-form-label">Forma de Pago</label>
                            <div class="col-md-2">
                                <select v-model="formulario.pago_forma" class="form-control" name="forma_pago">
                                    <option v-for="forma_pago in pago_formas" :key="forma_pago.id" :value="forma_pago.id">{{forma_pago.forma_pago}}</option>
                                </select>
                            </div>
                            <label for="operadora" class="col-md-2 col-form-label">Operadora</label>
                            <div class="col-md-2">
                                <input v-model="formulario.operadora" name="operadora" class="form-control" :disabled="formulario.pago_forma != 3">
                            </div>
                            <label for="num_trans" class="col-md-2 col-form-label">Núm. Trans.</label>
                            <div class="col-md-2">
                                <input v-model="formulario.numero_transaccion" name="num_trans" class="form-control" :disabled="formulario.pago_forma != 3">
                            </div>
                        </div>

                        <div class="form-group row ml-3">
                            <label for="moneda" class="col-md-2 col-form-label">Moneda</label>
                            <div class="col-md-2">
                                <select v-model="formulario.moneda" class="form-control" name="moneda">
                                    <option v-for="moneda in monedas" :key="moneda.id" :value="moneda">{{moneda.nombre}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="productos">
                            <table class="table table-light">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Stock Actual</th>
                                        <th>Cantidad</th>
                                        <th>Precio unitario</th>
                                        <th>Precio total</th>
                                        <th>IVA Total</th>
                                        <th><button class="btn btn-primary" @click="addDetalle()">+</button></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(detalle, index) in formulario.detalles" :key="detalle.id">
                                        <td width="15%">
                                            <select v-model="formulario.detalles[index].producto" class="form-control">
                                                <option v-for="producto in $global.productos" :key="producto.id" :value="producto">{{producto.nombre}}</option>
                                            </select>
                                        </td>
                                         <td width="15%">
                                            <input v-model="formulario.detalles[index].producto.stock_actual" class="form-control" disabled>
                                        </td>
                                        <td width="15%">
                                            <input v-model="formulario.detalles[index].cantidad" @keyup="calcularTotales(index)" class="form-control" autofocus>
                                        </td>
                                        <td width="15%">
                                            <input v-model="formulario.detalles[index].producto.precio_venta" class="form-control monto" disabled>
                                        </td>
                                        <td width="15%">
                                            <input v-model="formulario.detalles[index].precio_total" class="form-control monto" disabled>
                                        </td>
                                        <td width="15%">
                                            <input v-model="formulario.detalles[index].iva_total" class="form-control monto" disabled>
                                        </td>
                                        <td><button class="btn btn-primary" @click="removeDetalle(index)">-</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="col-4 mr-auto">
                            <h3>Total: {{calcularTotalFinal}}</h3>
                            <h6>Deuda: {{parseFloat(formulario.total - formulario.pago.toString().replace(/,/g, '')).toFixed(2).toLocaleString()}}</h6>
                        </div>
                        <div>
                            <input v-model="formulario.pago" placeholder="Introducir monto" class="form-control monto">
                            <button class="btn btn-primary" @click="facturar()">Pagar</button>
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
      pago_formas: [],
      monedas: [],
      formulario: {
        factura: "",
        cliente: null,
        pago_forma: null,
        pago: 0,
        numero_transaccion: null,
        operadora: null,
        moneda: null,
        detalles: [
          { producto: "", cantidad: 0, precio_total: 0, iva_total: 0 },
        ],
        total: 0,
        total_iva: 0,
      },
      errors: [],
    };
  },
  mounted() {
    axios.get("/api/pago-forma").then((resultado) => {this.pago_formas = resultado.data; console.log(this.pago_formas);});
    axios.get("/api/moneda").then((resultado) => (this.monedas = resultado.data));
    axios
      .get("/api/producto-seleccion")
      .then((resultado) => (this.$global.productos = resultado.data));
    $(".monto").each(function() {
        new AutoNumeric(this, [
            {'decimalCharacter':'.'},
            {'digitGroupSeparator':','},
            {'watchExternalChanges': true}
        ]);
    });
  },
  computed: {
    calcularTotalFinal() {
      this.formulario.total = 0;
      for (const detalle of this.formulario.detalles) {
        detalle.precio_total = this.numeroSinComa(detalle.precio_total);
        this.formulario.total += detalle.precio_total;
      }
      return parseFloat(this.formulario.total).toFixed(2).toLocaleString();
    },
  },
  methods: {
    numeroSinComa(numero) {
      return numero
        .toString()
        .replace(/,/g, "");
    },
    addDetalle() {
      this.formulario.detalles.push({
        producto: "",
        cantidad: 0,
        precio_total: 0,
        iva_total: 0,
      });
    },
    removeDetalle(index) {
      if (this.formulario.detalles.length != 1) {
        this.formulario.detalles.splice(index, 1);
      }
    },
    calcularTotales(index) {
      const detalle = this.formulario.detalles[index];
      const cantidad = this.numeroSinComa(detalle.cantidad);
      detalle.precio_total = cantidad * detalle.producto.precio_venta / this.formulario.moneda.valor;
      detalle.iva_total = (detalle.precio_total / (detalle.producto.iva * 0.01 + 1)) * detalle.producto.iva * 0.01;
    },
    facturar() {
      this.errors = [];
      this.formulario.cliente = this.$global.cliente.id;

      //Comprobar posibles errores y definir totales
      for (const detalle of this.formulario.detalles) {
        if (!detalle.producto) {
          this.errors.push("No deben permanecer detalles en blanco");
          return;
        }
        if (
          detalle.producto.stock_actual <
          this.numeroSinComa(detalle.cantidad)
        ) {
          this.errors.push(
            'La cantidad del producto "' +
              detalle.producto.nombre +
              '" supera al stock actual'
          );
          return;
        }
        if (!(detalle.cantidad > 0)) {
          this.errors.push("No deben permanecer detalles sin cantidad");
          return;
        }
        detalle.producto = detalle.producto.id;
        detalle.precio_total = this.numeroSinComa(detalle.precio_total);
        detalle.iva_total = this.numeroSinComa(detalle.iva_total);
        this.formulario.total_iva += detalle.iva_total;
      }
      this.formulario.total = this.numeroSinComa(this.formulario.total);
      this.formulario.pago = this.numeroSinComa(this.formulario.pago);

      //Guardar venta, luego imprimirla y después enviar correo
      axios.post("/api/venta", this.formulario).then((resultado) => {
        this.$emit("venta-creada");
        axios
          .post("/impresion", resultado.data, { responseType: "arraybuffer" })
          .then((response) => {
            let blob = new Blob([response.data], { type: "application/pdf" });
            let link = document.createElement("a");
            link.href = window.URL.createObjectURL(blob);
            link.download = "factura.pdf";
            link.click();
          });
        //axios.post("/api/mail", resultado.data).then("Correo enviado");
      });

      $("#nuevaVenta").modal("hide");
      $("#cliente").modal("hide");
      this.formulario = {
        factura: "",
        cliente: null,
        pago_forma: null,
        pago: 0,
        numero_transaccion: null,
        operadora: null,
        moneda: null,
        detalles: [
          { producto: "", cantidad: "", precio_total: "", iva_total: "" },
        ],
        total: 0,
        total_iva: 0,
      };
    },
    nuevoProducto() {
      $("#nuevaVenta").modal("hide");
      $("#nuevoProducto").modal("show");
    },
  },
};
</script>
