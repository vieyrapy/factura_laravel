<template>
    <div id="eliminar" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5>Eliminar</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="text-center">Desea realmente eliminar este registro?</p>
                    </div>
                    <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-danger" data-dismiss="modal" @click="eliminar()">Eliminar</button>
                    </div>
                </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'api',
            'registro'
        ],
        methods: {
            eliminar(){
                axios.put('/api/' + this.api + '/' + this.registro, {'eliminado': true}).then(console.log('Producto eliminado'));
                this.$emit('eliminado-producto');
            }
        }
    }
</script>
