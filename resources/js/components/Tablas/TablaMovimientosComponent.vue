<template>
  <div>
    <button
      type="button"
      class="btn btn-primary"
      data-toggle="modal"
      data-target="#cliente"
    >
      + Nueva Venta
    </button>
    <button class="btn btn-primary" data-toggle="modal" data-target="#proveedor">
      + Nuevo Movimiento
    </button>
    <!-- <button
      type="button"
      class="btn btn-primary"
      data-toggle="modal"
      data-target="#nuevoRecibo"
    >
      + Nuevo Recibo
    </button> -->
    <button class="btn btn-primary" @click="generarReporte">Speed PDF</button>
    <button class="btn btn-dark">Cerrar Caja</button>
    <div class="row vw-100 my-3 ml-1">
      <div class="dropdown mr-2">
        <button
          class="btn btn-secondary dropdown-toggle"
          type="button"
          id="dropdownVenta"
          data-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false"
        >
          Filtrar venta
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownVenta">
          <div class="dropdown-item">
            <label>Número: </label
            ><input
              class="ml-1 venta"
              v-model="ventas.numero_factura"
              @keyup="filtrar($event)"
            />
          </div>
          <div class="dropdown-item">
            <label>Cliente: </label
            ><input
              class="ml-1 venta"
              v-model="ventas.cliente"
              @keyup="filtrar($event)"
            />
          </div>
          <div class="dropdown-item">
            <label>Pago: </label
            ><input class="ml-1 venta" v-model="ventas.pago" @keyup="filtrar($event)" />
          </div>
        </div>
      </div>
      <div class="dropdown mr-2">
        <button
          class="btn btn-secondary dropdown-toggle"
          type="button"
          id="dropdownMovimiento"
          data-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false"
        >
          Filtrar movimiento
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMovimiento">
          <div class="dropdown-item">
            <label>Proveedor: </label
            ><input
              class="ml-1 movimiento"
              v-model="movimientos.proveedor"
              @keyup="filtrar($event)"
            />
          </div>
          <div class="dropdown-item">
            <label>Categoria: </label
            ><input
              class="ml-1 movimiento"
              v-model="movimientos.categoria"
              @keyup="filtrar($event)"
            />
          </div>
          <div class="dropdown-item">
            <label>Concepto: </label
            ><input
              class="ml-1 movimiento"
              v-model="movimientos.concepto"
              @keyup="filtrar($event)"
            />
          </div>
          <div class="dropdown-item">
            <label>Tipo de Movimiento: </label
            ><input
              class="ml-1 movimiento"
              v-model="movimientos.tipo"
              @keyup="filtrar($event)"
            />
          </div>
        </div>
      </div>
      <!-- <div class="dropdown mr-2">
          <button
            class="btn btn-secondary dropdown-toggle"
            type="button"
            id="dropdownRecibo"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            Filtrar recibo
          </button>
        </div> -->
      <select
        @change="changeFiltros()"
        v-model="formularioFiltros.filtro"
        class="custom-select ml-2 col-2"
      >
        <option v-for="filtro in filtros" v-bind:key="filtro.id" :value="filtro.id">
          {{ filtro.descripcion }}
        </option>
      </select>

      <div class="col-6 d-inline-block float-right">
        <div v-if="formularioFiltros.filtro == 1" class="d-inline-block col-12 p-0 m-0">
          <label class="d-inline-block">Desde:</label>
          <input
            @change="filtrar()"
            type="date"
            v-model="formularioFiltros.date_ini"
            class="form-control d-inline-block date col-4"
          />

          <label class="d-inline-block">Hasta:</label>
          <input
            @change="filtrar()"
            type="date"
            v-model="formularioFiltros.date_fin"
            class="form-control d-inline-block date col-4"
          />
        </div>
        <div v-if="formularioFiltros.filtro == 2" class="d-inline-block col-12">
          <label class="d-inline-block">Desde:</label>
          <input
            @change="filtrar()"
            type="month"
            v-model="formularioFiltros.date_ini"
            class="form-control d-inline-block date col-4"
          />

          <label class="d-inline-block">Hasta:</label>
          <input
            @change="filtrar()"
            type="month"
            v-model="formularioFiltros.date_fin"
            class="form-control d-inline-block date col-4"
          />
        </div>
        <div v-if="formularioFiltros.filtro == 3" class="d-inline-block col-12">
          <label class="d-inline-block">Desde:</label>
          <select
            @change="filtrar()"
            v-model="formularioFiltros.date_ini"
            class="form-control d-inline-block date col-4"
          >
            <option v-for="i in new Date().getFullYear() - 2000" :key="i">
              {{ 2000 + i }}
            </option>
          </select>

          <label class="d-inline-block">Hasta:</label>
          <select
            @change="filtrar(this.pagination.current_page)"
            v-model="formularioFiltros.date_fin"
            class="form-control d-inline-block date col-4"
          >
            <option v-for="i in new Date().getFullYear() - 2000" :key="i">
              {{ 2000 + i }}
            </option>
          </select>
        </div>
      </div>
    </div>
    <div v-if="listado_movimientos.length != 0" class="row justify-content-center">
      <table class="table table-hover thead-light text-center">
        <thead>
          <th>Fecha</th>
          <th v-if="listado_movimientos[0].categoria">Categoria</th>
          <th v-if="listado_movimientos[0].proveedor">Proveedor</th>
          <th v-if="listado_movimientos[0].concepto">Concepto</th>
          <th>Total</th>
          <th colspan="2" v-if="listado_movimientos[0].id"></th>
        </thead>
        <tbody>
          <tr v-for="movimiento in listado_movimientos" :key="movimiento.id">
            <td>{{ movimiento.fecha }}</td>
            <td v-if="movimiento.categoria">
              {{ movimiento.categoria.nombre }}
            </td>
            <td v-if="movimiento.proveedor">
              {{ movimiento.proveedor.nombres }}
            </td>
            <td v-if="movimiento.concepto">{{ movimiento.concepto }}</td>
            <td>{{ new Intl.NumberFormat().format(movimiento.monto) }}</td>
            <td v-if="movimiento.id"><a>Detalles</a></td>
            <td v-if="movimiento.id">
              <a href="#">Imprimir</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div v-if="listado_ventas.length != 0" class="row justify-content-center">
      <table class="table table-hover thead-light text-center">
        <thead>
          <th>Fecha</th>
          <th v-if="listado_ventas[0].factura_numero">Fact. Num</th>
          <th v-if="listado_ventas[0].cliente">Cliente</th>
          <th>Pago</th>
          <th>Total</th>
          <th colspan="2" v-if="listado_ventas[0].id"></th>
        </thead>
        <tbody>
          <tr v-for="venta in listado_ventas" :key="venta.id">
            <td>{{ venta.fecha }}</td>
            <td v-if="venta.factura_numero">{{ venta.factura_numero }}</td>
            <td v-if="venta.cliente">{{ venta.cliente }}</td>
            <td>{{ venta.forma_pago }}</td>
            <td>{{ new Intl.NumberFormat().format(venta.monto) }}</td>
            <td v-if="venta.id"><a>Detalles</a></td>
            <td v-if="venta.id">
              <a href="#">Imprimir</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <nav>
      <ul class="pagination">
        <li class="page-item" v-if="pagination.current_page > 1">
          <a
            class="page-link"
            href="#"
            @click.prevent="changePage(pagination.current_page - 1)"
          >
            <span>Anterior</span>
          </a>
        </li>
        <li
          class="page-item"
          v-for="page in pagesNumber"
          :key="page"
          :class="[page == isActivated ? 'active' : '']"
        >
          <a class="page-link" href="#" @click.prevent="changePage(page)">
            {{ page }}
          </a>
        </li>
        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
          <a
            class="page-link"
            href="#"
            @click.prevent="changePage(pagination.current_page + 1)"
          >
            <span>Siguiente</span>
          </a>
        </li>
      </ul>
    </nav>
    <seleccion-proveedor-component></seleccion-proveedor-component>
    <seleccion-cliente-component></seleccion-cliente-component>
    <nueva-venta-component @venta-creada="filtrar()"></nueva-venta-component>
    <eliminar-component
      :api="api_eliminar"
      :registro="id_eliminar"
      @eliminado="filtrar()"
    ></eliminar-component>
  </div>
</template>

<script>
import EliminarComponent from "../Formularios/EliminarComponent.vue";
export default {
  components: { EliminarComponent },
  data: () => {
    return {
      formularioFiltros: {
        filtro: 1,
        date_ini: "",
        date_fin: "",
      },
      filtros: [
        { id: 1, descripcion: "Filtrar según Fechas" },
        { id: 2, descripcion: "Filtrar según Meses" },
        { id: 3, descripcion: "Filtrar según Años" },
      ],
      ventas: {
        numero_factura: "",
        cliente: "",
        pago: "",
      },
      movimientos: {
        proveedor: "",
        categoria: "",
        concepto: "",
        tipo: "",
      },
      is_venta: true,
      api_eliminar: "",
      id_eliminar: "",
      listado_ventas: [],
      listado_movimientos: [],
      pagination: {
        total: 0,
        current_page: 0,
        per_page: 0,
        last_page: 0,
        from: 0,
        to: 0,
      },
    };
  },
  created() {
    this.formularioFiltros.date_ini = this.fechaActual();
    this.formularioFiltros.date_fin = this.fechaActual();
    this.filtrar(null, 1, true);
  },
  computed: {
    isActivated() {
      return this.pagination.current_page;
    },
    pagesNumber() {
      if (!this.pagination.to) {
        return [];
      }

      let from = this.pagination.current_page - 2;
      if (from < 1) {
        from = 1;
      }

      let to = from + 2 * 2;
      if (to >= this.pagination.last_page) {
        to = this.pagination.last_page;
      }

      let pagesArray = [];
      while (from <= to) {
        pagesArray.push(from);
        from++;
      }
      return pagesArray;
    },
    movimientoVacio() {
      return {
        fecha: this.fechaActual(),
        nombre: "",
        categoria: "",
        concepto: "",
        tipo: "Ingreso",
      };
    },
  },
  methods: {
    creadoMovimiento() {
      this.movimientoEditar = this.movimientoVacio;
      this.filtrar(this.pagination.current_page);
    },
    fechaActual(anos = 0) {
      const fecha = new Date();
      let mes = fecha.getMonth() + 1;
      let dia = fecha.getDate();
      const ano = fecha.getFullYear() - anos;
      return this.fecha(dia, mes, ano);
    },

    fecha(dia, mes, ano) {
      if (dia.toString().length == 1) dia = "0" + dia;
      if (mes.toString().length == 1) mes = "0" + mes;
      return ano + "-" + mes + "-" + dia;
    },

    mes(mes, ano) {
      if (mes.toString().length == 1) mes = "0" + mes;
      return ano + "-" + mes;
    },

    changePage(page) {
      this.pagination.current_page = page;
      this.filtrar(null, page);
    },

    eliminar(id, api) {
      this.id_eliminar = id;
      this.api_eliminar = api;
      $("#eliminar").modal("show");
    },

    generarReporte() {
      axios
        .post("/api/reporte", this.formularioFiltros, {
          responseType: "arraybuffer",
        })
        .then((response) => {
          let blob = new Blob([response.data], { type: "application/pdf" });
          let link = document.createElement("a");
          link.href = window.URL.createObjectURL(blob);
          link.download = "reporte.pdf";
          link.click();
        });
    },

    changeFiltros() {
      let date_ini = this.formularioFiltros.date_ini.split("-");
      let date_fin = this.formularioFiltros.date_fin.split("-");
      switch (this.formularioFiltros.filtro) {
        case 1:
          switch (date_ini.length) {
            case 1:
              this.formularioFiltros.date_ini = this.fecha(1, 1, date_ini[0]);
              this.formularioFiltros.date_fin = this.fecha(1, 1, date_fin[0]);
              break;
            case 2:
              this.formularioFiltros.date_ini = this.fecha(1, date_ini[1], date_ini[0]);
              this.formularioFiltros.date_fin = this.fecha(1, date_fin[1], date_fin[0]);
              break;
          }
          break;
        case 2:
          switch (date_ini.length) {
            case 1:
              this.formularioFiltros.date_ini = this.mes(1, date_ini[0]);
              this.formularioFiltros.date_fin = this.mes(1, date_fin[0]);
              break;
            case 3:
              this.formularioFiltros.date_ini = this.mes(date_ini[1], date_ini[0]);
              this.formularioFiltros.date_fin = this.mes(date_fin[1], date_fin[0]);
              break;
          }
          break;
        case 3:
          this.formularioFiltros.date_ini = date_ini[0];
          this.formularioFiltros.date_fin = date_fin[0];
          break;
      }
      this.filtrar(null, this.pagination.current_page);
    },

    filtrar(evento = null, page = 1, apertura = false) {
      this.is_venta =
        evento == null ? this.is_venta : evento.target.classList.contains("venta");
      if (this.is_venta) {
        this.movimientos = {
          proveedor: "",
          categoria: "",
          concepto: "",
          tipo: "",
        };
        axios
          .get(
            "api/venta?page=" +
              page +
              "&filters=" +
              JSON.stringify(this.formularioFiltros) +
              "&ventas=" +
              JSON.stringify(this.ventas) +
              "&apertura=" +
              apertura
          )
          .then((resultado) => {
            this.listado_ventas = resultado.data.ventas.data;
            this.listado_movimientos = [];
            this.pagination = resultado.data.pagination;
            this.is_venta = true;
          });
      } else {
        this.ventas = {
          numero_factura: "",
          cliente: "",
          pago: "",
        };
        axios
          .get(
            "api/movimiento?page=" +
              page +
              "&filters=" +
              JSON.stringify(this.formularioFiltros) +
              "&movimientos=" +
              JSON.stringify(this.movimientos)
          )
          .then((resultado) => {
            this.listado_movimientos = resultado.data.movimientos;
            this.listado_ventas = [];
            this.pagination = resultado.data.pagination;
            this.is_venta = false;
          });
      }
    },
  },
};
</script>
