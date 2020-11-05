<template>
  <div class="row justify-content-center">
    <div class="col-sm">
      <div class="cold-md-4">
        <div class="active-cyan-3 active-cyan-4 mb-4">
          <input v-model="name" class="form-control" placeholder="Buscar..." />
        </div>
        <button @click="getPagos(1)" class="btn btn-outline-primary">
          Buscar
        </button>
        <br />
      </div>

      <table class="table table-hover table-striped">
        <thead>
          <tr>
            <th width="20px">Nº</th>
            <th>Fecha</th>
            <th>Nombre</th>
            <th>Debe</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="pago in pagos" :key="pago.id">
            <td>{{ pago.id }}</td>
            <td>{{ pago.created_at }}</td>
            <td>
              <a :href="'clientes/' + pago.id">{{ pago.clientes.nombre }}</a>
            </td>
            <td>
              <a :href="'clientes/' + pago.id">{{ pago.saldo }}</a>
            </td>
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
    </div>
    <nuevo-pago-component @pago-registrado="getPagos(pagination.current_page)"></nuevo-pago-component>
  </div>
</template>

<script>
export default {
  data: () => {
    return {
      pagos: [],
      name: "",
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
    this.getPagos(1);
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
    getPagos(page) {
      axios
        .get("/api/pago?page=" + page, { params: { name: this.name } })
        .then((resultado) => {
          console.log(resultado);
          this.pagos = resultado.data.pagos.data;
          this.pagination = resultado.data.pagination;
        });
    },
    changePage(page) {
      this.pagination.current_page = page;
      this.getPagos(page);
    },
  },
};
</script>
