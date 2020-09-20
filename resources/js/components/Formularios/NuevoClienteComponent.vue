<template>
    <div class="modal" id="nuevoCliente" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nueva Cliente</h5>
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
                                <input v-model="formulario.nombre" name="nombre" type="text" autocomplete="off" class="form-control" required autofocus >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ruc" class="col-md-4 col-form-label text-md-right">RUC</label>
                            <div class="col-md-6">
                                <input v-model="formulario.ruc" name="ruc" type="text" autocomplete="off" class="form-control" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
                            <div class="col-md-6">
                                <input v-model="formulario.email" name="email" type="email" autocomplete="off" class="form-control" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="telefono" class="col-md-4 col-form-label text-md-right">Telefono</label>
                            <div class="col-md-6">
                                <input v-model="formulario.telefono" name="telefono" type="text" autocomplete="off" class="form-control" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="direccion" class="col-md-4 col-form-label text-md-right">Dirección</label>
                            <div class="col-md-6">
                                <input v-model="formulario.direccion" name="direccion" type="text" autocomplete="off" class="form-control" required autofocus>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <!-- v-if="window.location.split('/') == 'ventas'" -->
                        <button @click="guardar()" class="btn btn-primary" data-toggle="modal" data-target="#nuevaVenta">Guardar</button>
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
                    nombre: "",
                    ruc: "",
                    email: "",
                    telefono: "",
                    direccion: ""
                },
                errors: []
            }
        },
        methods: {
            guardar(){
                if(this.formulario.nombre == "" || this.formulario.ruc == ""){
                    errors.push('Aún hay campos que deben ser completados');
                    return;
                }
                axios.post('/api/clientes', this.formulario).then(resultado => this.$global.cliente = resultado.data);
                axios.get('/api/clientes').then(resultado => this.$$global.clientes = resultado.data);
                $('#nuevoCliente').modal('hide');
            }
        }
    }
</script>
