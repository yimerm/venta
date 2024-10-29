<template>
	<div class="modal fade" id="deletecategoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header" align="center">
	        <h5 class="modal-title" id="exampleModalLabel">Eliminar Categoria</h5>
	        <button type="button"  class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body" align="center">
	       	<p>La siguiente Categoria será eliminada:</p> 
	       	<h5 class="modal-title">{{ nombre}} </h5>
			<div class="form-group" align="center">
				<a href="#" type="submit"  @click="destroyProducto()" class="btn btn-danger">Eliminar</a> 
				<a href="#" type="submit" @click="reset()" class="btn btn-secondary" data-dismiss="modal">Cancelar</a>
			</div>
	      </div>
	    </div>
	  </div>
	</div>
</template>
<script>

import EventBus from '../../event-bus';
	 export default {
	 	data() {
	 		return {
	 			nombre: null, 
	 			slug_categoria : null,
	 		}
	 	},
		mounted() {
			EventBus.$on('categoria-delete', data => {
			this.slug_categoria = data.slug_categoria;
			this.nombre = data.nombre;
			});
		},
		methods: {
			destroyProducto: function(){
				let metodo = this;
				axios.delete('http://venta.test/categoria/'+this.slug_categoria).
				then(function(response){
					EventBus.$emit('categoria12-tabla');
					metodo.reset();
				})
				.catch(function(error){
					console.log(error)
				});
			},
			reset: function(){
				this.nombre = "" ;
				this.slug_categoria = "";
				$('#deletecategoria').modal('hide');
				$(document.body).removeClass('modal-open');
				$('.modal-backdrop').remove();
			}
		}
    }

</script>