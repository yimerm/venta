<template>
	<div class="modal fade" id="deleteProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header" align="center">
	        <h5 class="modal-title" id="exampleModalLabel">Eliminar proveedor</h5>
	        <button type="button"  class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body" align="center">
	       	<p>El siguiente proveedor será eliminado:</p> 
	       	<h5 class="modal-title">{{ nombre}} </h5>
			<div class="form-group" align="center">
				<button type="button"  @click="destroyProducto()" class="btn btn-danger">Eliminar</button> 
				<button type="button" @click="reset()" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
			</div>
	      </div>
	    </div>
	  </div>
	</div>
</template>
<script>

import EventBus from '../../event-bus';
	 export default 
	{
	 	data() {
	 		return {
	 			nombre: null, 
	 			slug_proveedor : null,
	 		}
	 	},
        mounted() {
					EventBus.$on('proveedor-delete', data => {
					this.slug_proveedor = data.slug_proveedor;
					this.nombre = data.nombre;
					});
        },
        methods: 
				{
        	destroyProducto: function(){
        	let metodo = this;
    			axios.delete('http://venta.test/proveedor/'+this.slug_proveedor).
    			then(function(response){
						EventBus.$emit('proveedor-agregar', response.data.productos)
						metodo.reset();
    			}).catch(function(error){
    				console.log(error)
    			});
        	},
        	reset: function(){
						this.nombre = "" ;
						this.slug_proveedor = "";
						$('#deleteProducto').modal('hide');
						$(document.body).removeClass('modal-open');
						$('.modal-backdrop').remove();
        	}
        }
  }

</script>