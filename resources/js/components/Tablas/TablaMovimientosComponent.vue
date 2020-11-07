<template>
  <div>
    <button class="btn btn-primary" data-toggle="modal"
      data-target="#nuevoMovimiento">
      + Nuevo Movimiento
    </button>
    <button
      type="button"
      class="btn btn-primary"
      data-toggle="modal"
      data-target="#nuevaCategoria"
    >
      + Nueva Categoría
    </button>
    <button
      type="button"
      class="btn btn-primary"
      data-toggle="modal"
      data-target="#cliente"
    >
      + Nueva Venta
    </button>
    <button class="btn btn-primary" @click="generarReporte">Generar PDF</button>
    <div class="m-3 row">
      <div class="col-5 row">
        <select
          @change="getMovimientos(pagination.current_page)"
          v-model="formularioFiltros.categoria"
          class="custom-select col"
        >
          <option value="">Filtrar por categoria</option>
          <option
            v-for="categoria in categorias"
            v-bind:key="categoria.id"
            :value="categoria.id"
          >
            {{ categoria.nombreCategoria }}
          </option>
        </select>
        <select
          @change="
            changeFiltros();
          "
          v-model="formularioFiltros.filtro"
          class="custom-select ml-2 col"
        >
          <option
            v-for="filtro in filtros"
            v-bind:key="filtro.id"
            :value="filtro.id"
          >
            {{ filtro.descripcion }}
          </option>
        </select>
      </div>
      <div class="col-7 d-inline-block float-right">
        <div v-if="formularioFiltros.filtro == 1" class="d-inline-block col-10">
          <label class="d-inline-block">Desde:</label>
          <input
            @change="getMovimientos(pagination.current_page)"
            type="date"
            v-model="formularioFiltros.date_ini"
            class="form-control d-inline-block date col-4"
          />

          <label class="d-inline-block">Hasta:</label>
          <input
            @change="getMovimientos(pagination.current_page)"
            type="date"
            v-model="formularioFiltros.date_fin"
            class="form-control d-inline-block date col-4"
          />
        </div>
        <div v-if="formularioFiltros.filtro == 2" class="d-inline-block col-10">
          <label class="d-inline-block">Desde:</label>
          <input
            @change="getMovimientos(pagination.current_page)"
            type="month"
            v-model="formularioFiltros.date_ini"
            class="form-control d-inline-block date col-4"
          />

          <label class="d-inline-block">Hasta:</label>
          <input
            @change="getMovimientos(pagination.current_page)"
            type="month"
            v-model="formularioFiltros.date_fin"
            class="form-control d-inline-block date col-4"
          />
        </div>
        <div v-if="formularioFiltros.filtro == 3" class="d-inline-block col-10">
          <label class="d-inline-block">Desde:</label>
          <select
            @change="getMovimientos(pagination.current_page)"
            v-model="formularioFiltros.date_ini"
            class="form-control d-inline-block date col-4"
          >
            <option v-for="i in new Date().getFullYear() - 2000" :key="i">
              {{ 2000 + i }}
            </option>
          </select>

          <label class="d-inline-block">Hasta:</label>
          <select
            @change="getMovimientos(this.pagination.current_page)"
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
    <div class="row justify-content-center">
      <table class="table table-hover thead-light text-center">
        <thead>
          <th>Fecha</th>
          <th>Categoria</th>
          <th v-if="formularioFiltros.filtro == 1">Nombre</th>
          <th v-if="formularioFiltros.filtro == 1">Concepto</th>
          <th>Ingreso</th>
          <th>Egreso</th>
          <th v-if="formularioFiltros.filtro == 1">Acciones</th>
        </thead>
        <tbody>
          <tr v-for="movimiento in movimientos" :key="movimiento.id">
            <td>{{ movimiento.fecha }}</td>
            <td>{{ movimiento.categoria.nombreCategoria }}</td>
            <td v-if="formularioFiltros.filtro == 1">
              {{ movimiento.entidad }}
            </td>
            <td v-if="formularioFiltros.filtro == 1">
              {{ movimiento.concepto }}
            </td>
            <td>{{ new Intl.NumberFormat().format(movimiento.ingreso) }}</td>
            <td>{{ new Intl.NumberFormat().format(movimiento.egreso) }}</td>
            <td v-if="formularioFiltros.filtro == 1">
              <button class="btn btn-primary" @click="editar(movimiento)">
                Modificar
              </button>
              <button class="btn btn-primary" @click="eliminar(movimiento.id)">
                Eliminar
              </button>
            </td>
          </tr>
          <tr>
            <td :colspan="formularioFiltros.filtro == 1 ? 4 : 2">Totales:</td>
            <td>{{ new Intl.NumberFormat().format(totales["ingreso"]) }}</td>
            <td>{{ new Intl.NumberFormat().format(totales["egreso"]) }}</td>
          </tr>
          <tr>
            <td :colspan="formularioFiltros.filtro == 1 ? 4 : 2">
              Total final:
            </td>
            <td colspan="2">
              {{
                new Intl.NumberFormat().format(
                  totales["ingreso"] - totales["egreso"]
                )
              }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <seleccion-proveedor-component></seleccion-proveedor-component>
    <nuevo-movimiento-component
      :formulario="movimientoEditar"
      @creado-movimiento="getMovimientos(pagination.current_page)"
    ></nuevo-movimiento-component>
    <nuevo-proveedor-component></nuevo-proveedor-component>
    <eliminar-component
      api="movimiento"
      :registro="movimientoEliminar"
      @eliminado="getMovimientos(pagination.current_page)"
    ></eliminar-component>
    <nueva-categoria-movimiento-component
      @creada-categoria="getCategorias"
    ></nueva-categoria-movimiento-component>
    <seleccion-cliente-component></seleccion-cliente-component>
    <nuevo-cliente-component></nuevo-cliente-component>
    <nueva-venta-component
      @venta-creada="getMovimientos(pagination.current_page)"
    ></nueva-venta-component>
  </div>
</template>

<script>
export default {
  data: () => {
    return {
      formularioFiltros: {
        categoria: "",
        filtro: 1,
        date_ini: "",
        date_fin: "",
      },
      categorias: [],
      filtros: [
        { id: 1, descripcion: "Filtrar según Fechas" },
        { id: 2, descripcion: "Filtrar según Meses" },
        { id: 3, descripcion: "Filtrar según Años" },
      ],
      movimientoEditar: {},
      movimientoEliminar: 0,
      movimientos: [],
      totales: [],
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
  mounted() {
    this.formularioFiltros.date_ini = this.fechaActual(1);
    this.formularioFiltros.date_fin = this.fechaActual();
    this.getCategorias();
    this.getMovimientos();
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
        tipo: 1,
      };
    },
  },
  methods: {
      fechaActual(anos = 0) {
        const fecha = new Date();
        let mes = fecha.getMonth() + 1;
        let dia = fecha.getDate();
        const ano = fecha.getFullYear() - anos;
        return this.fecha(dia, mes, ano);
    },

    fecha(dia, mes, ano){
        if (dia.toString().length == 1) dia = "0" + dia;
        if (mes.toString().length == 1) mes = "0" + mes;
        return ano + "-" + mes + "-" + dia;
    },

    mes(mes, ano){
        if (mes.toString().length == 1) mes = "0" + mes;
        return ano + "-" + mes;
    },

    getMovimientos(page = 1) {
      axios
        .get(
          "/api/movimiento?page=" +
            page +
            "&filters=" +
            JSON.stringify(this.formularioFiltros)
        )
        .then((resultado) => {
          this.movimientos = resultado.data.movimientos.data;
          this.totales = resultado.data.totales;
          this.pagination = resultado.data.pagination;
        });
    },

    changePage(page) {
      this.pagination.current_page = page;
      this.getMovimientos(page);
    },

    editar(movimiento = this.movimientoVacio) {
      this.movimientoEditar = Object.assign({}, movimiento);
      $("#nuevoMovimiento").modal("show");
    },

    eliminar(id) {
      this.movimientoEliminar = id;
      $("#eliminar").modal("show");
    },

    getCategorias() {
      axios.get("/api/categoria").then((resultado) => {
        this.categorias = resultado.data;
      });
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

    changeFiltros(){
        let date_ini = this.formularioFiltros.date_ini.split("-");
        let date_fin = this.formularioFiltros.date_fin.split("-");
        switch(this.formularioFiltros.filtro){
            case 1: switch(date_ini.length){
                case 1: this.formularioFiltros.date_ini = this.fecha(1, 1, date_ini[0]); this.formularioFiltros.date_fin = this.fecha(1, 1, date_fin[0]); break;
                case 2: this.formularioFiltros.date_ini = this.fecha(1, date_ini[1], date_ini[0]); this.formularioFiltros.date_fin = this.fecha(1, date_fin[1], date_fin[0]); break;
            }; break;
            case 2: switch(date_ini.length){
                case 1: this.formularioFiltros.date_ini = this.mes(1, date_ini[0]); this.formularioFiltros.date_fin = this.mes(1, date_fin[0]); break;
                case 3: this.formularioFiltros.date_ini = this.mes(date_ini[1], date_ini[0]); this.formularioFiltros.date_fin = this.mes(date_fin[1], date_fin[0]); break;
            }; break;
            case 3: this.formularioFiltros.date_ini = date_ini[0]; this.formularioFiltros.date_fin = date_fin[0]; break;
            }
        this.getMovimientos(this.pagination.current_page);
        }
  },
};
</script>
