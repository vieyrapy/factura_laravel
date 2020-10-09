<template>
  <div class="col sm">
    <button
      type="button"
      class="btn btn-primary"
      data-toggle="modal"
      data-target="#cliente"
    >
      + Nueva Venta
    </button>
    <table class="table table-hover thead-light text-center">
      <thead>
        <th>Nro de Factura</th>
        <th>Fecha</th>
        <th>Condición de Venta</th>
        <th>Cliente</th>
        <th>Total</th>
      </thead>
      <tbody>
        <tr v-for="venta in ventas" :key="venta.id">
          <td>{{ venta.nro_factura }}</td>
          <td>{{ venta.created_at }}</td>
          <td>{{ venta.condicion_venta }}</td>
          <td>{{ venta.cliente.nombre }}</td>
          <td>{{ venta.total }}</td>
        </tr>
      </tbody>
    </table>
    <nav>
      <ul class="pagination">
        <li class="page-item" v-if="pagination.current_page > 1">
          <a
            class="page-link"
            href="#"
            @click.prevent="changePage(pagination.current_page - 1)"
          >
            <span>Atras</span>
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
        <li
          class="page-item"
          v-if="pagination.current_page < pagination.last_page"
        >
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
    <seleccion-cliente-component></seleccion-cliente-component>
    <nuevo-cliente-component></nuevo-cliente-component>
    <nueva-venta-component
      @venta-creada="getVentas(pagination.current_page)"
    ></nueva-venta-component>
  </div>
</template>

<script>
export default {
  data: () => {
    return {
      ventas: [],
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
    this.getVentas(1);
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
  },
  methods: {
    getVentas(page) {
      axios.get("/api/venta?page=" + page).then((resultado) => {
        this.ventas = resultado.data.ventas.data;
        this.pagination = resultado.data.pagination;
      });
    },
    changePage(page) {
      this.pagination.current_page = page;
      this.getVentas(page);
    },
  },
};
</script>
