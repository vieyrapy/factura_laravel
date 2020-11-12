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

                        <p v-if="errors.length">
                            <b>Por favor, corrija el(los) siguiente(s) error(es):</b>
                            <ul>
                            <li v-for="error in errors" :key="error">{{ error }}</li>
                            </ul>
                        </p>

                        <div class="form-group row">
                            <label for="factura" class="col-md-4 col-form-label text-md-right">Número de Factura</label>
                            <div class="col-md-6">
                                <input v-model="formulario.factura" name="factura" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nombre" class="col-md-4 col-form-label text-md-right">Cliente</label>
                            <div class="col-md-6">
                                <input v-model="$global.cliente.nombre" name="nombre" class="form-control" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Condición de venta</label>
                            <div class="col-3 align-self-center text-center">
                                <input type="radio" id="contado" name="tipo" value="Contado" v-model="formulario.condicion"><label for="Contado">&nbsp Contado</label>
                            </div>
                            <div class="col-3 align-self-center text-center">
                                <input type="radio" id="credito" name="tipo" value="Credito" v-model="formulario.condicion"><label for="Credito">&nbsp Crédito</label>
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
                                            <input v-model="formulario.detalles[index].producto.precio_venta" class="form-control" disabled>
                                        </td>
                                        <td width="15%">
                                            <input v-model="formulario.detalles[index].precio_total" class="form-control" disabled>
                                        </td>
                                        <td width="15%">
                                            <input v-model="formulario.detalles[index].iva_total" class="form-control" disabled>
                                        </td>
                                        <td><button class="btn btn-primary" @click="removeDetalle(index)">-</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="modal-footer d-flex">
                        <button class="btn btn-primary mx-auto" @click="facturar()">Generar factura</button>
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
        factura: "",
        cliente: null,
        condicion: "Contado",
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
    axios
      .get("/api/producto-seleccion")
      .then((resultado) => (this.$global.productos = resultado.data));
  },
  methods: {
      numeroConComa(numero) {
      return numero.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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
      const cantidad = detalle.cantidad.toString().replace(/,/g, "");
      detalle.precio_total = cantidad * detalle.producto.precio_venta;
      detalle.iva_total = this.numeroConComa(detalle.precio_total * detalle.producto.iva);
      detalle.precio_total = this.numeroConComa(detalle.precio_total);
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
        if (detalle.producto.stock_actual < detalle.cantidad.toString().replace(/,/g, "")) {
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
        detalle.precio_total = detalle.precio_total.toString().replace(/,/g, "");
        detalle.iva_total = detalle.iva_total.toString().replace(/,/g, "");
        this.formulario.total += detalle.precio_total;
        this.formulario.total_iva += detalle.iva_total;
      }

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
        axios.post("/api/mail", resultado.data).then("Correo enviado");
      });

      $("#nuevaVenta").modal("hide");
      $("#cliente").modal("hide");
      this.formulario = {
        factura: "",
        cliente: null,
        condicion: "Contado",
        detalles: [
          { producto: "", cantidad: "", precio_total: "", iva_total: "" },
        ],
        total: 0,
        total_iva: 0,
      };
    },
  },
};
</script>
