
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

let shared = new Vue({
    data:{
        cliente: {},
        productos: [],
        clientes: [],
        categorias: []
    }
});

shared.install = () => {
    Object.defineProperty(Vue.prototype, "$global", {
        get () { return shared }
    })
};
Vue.use(shared);

Vue.component('nuevo-pago-component', require('./components/Formularios/NuevoPagoComponent.vue').default);
Vue.component('nuevo-cliente-component', require('./components/Formularios/NuevoClienteComponent.vue').default);
Vue.component('nueva-venta-component', require('./components/Formularios/NuevaVentaComponent.vue').default);
Vue.component('nueva-categoria-producto-component', require('./components/Formularios/NuevaCategoriaProductoComponent.vue').default);
Vue.component('nuevo-producto-component', require('./components/Formularios/NuevoProductoComponent.vue').default);
Vue.component('eliminar-component', require('./components/Formularios/EliminarComponent.vue').default);

Vue.component('tabla-pagos-component', require('./components/Tablas/TablaPagosComponent.vue').default);
Vue.component('tabla-ventas-component', require('./components/Tablas/TablaVentasComponent.vue').default);
Vue.component('tabla-productos-component', require('./components/Tablas/TablaProductosComponent.vue').default);

Vue.component('seleccion-cliente-component', require('./components/SeleccionClienteComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});
