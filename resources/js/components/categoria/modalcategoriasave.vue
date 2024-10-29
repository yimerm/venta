<template>
	<div class="modal fade" id="nuevacategoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">{{ titulo }}</h5>
	        <button type="button" @click="reset()" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <form  @submit.prevent="guardarcategoria"   class="form-group" id="formProductos" enctype = "multipart / form-data" autocomplete="off">
						<div class="form-group"> 
							<div class="input-group input-group-lg">
								<div class="input-group-prepend">
									<div for="nombre" class="input-group-text">Nombre</div>
								</div>
								<input type="text" class="form-control" id="nombre" aria-describedby="nombreHelp" placeholder="nombre de la categoria" v-model="nombre">
							</div>
						</div>
						<div class="form-group" align="center">
							<button type="submit" class="btn btn-success">Guardar</button> 
							<button type="button" @click="reset()" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
						</div>
	        </form>
	      </div>
	    </div>
	  </div>
	</div>
</template>
<script>
	import EventBus from '../../event-bus';
export default 
	{
		data(){
			return{ 
				nombre:'',
				slug_categoria:'',
				update : 0,
				titulo : "Nuevo Producto",
			}
		},
		mounted() {
			EventBus.$on('cliente-edit', data => {
				this.nombre = data.nombre;
				this.slug_categoria = data.slug_categoria;
				this.update = 1;
				this.titulo = "Editar Productos";
			});
    },
		methods: {
			guardarcategoria: function()
			{
				let metodo = this;
				if (this.update==0)
				{
					var data = new  FormData();
					//Añadimos la imagen seleccionada
					data.append('nombre', this.nombre);
					//Añadimos el método PUT dentro del formData
					// Como lo hacíamos desde un formulario simple _(no ajax)_
					data.append('_method', 'POST');
					//Enviamos la petición
					axios.post('http://venta.test/categoria',data)
					.then(function(res){
						EventBus.$emit('categoria12-tabla');
						$('#nuevacategoria').modal('hide')
						$(document.body).removeClass('modal-open');
						$('.modal-backdrop').remove(); 
						metodo.reset();
					})
					.catch(function(err){
						console.log(err)
					});
				}
				else
				{ 
					var data = new  FormData(); 
					//Añadimos la imagen seleccionada 
					data.append('nombre', this.nombre);
					data.append('slug_categoria', this.slug_categoria);
					//Añadimos el método PUT dentro del formData
					// Como lo hacíamos desde un formulario simple _(no ajax)_
						data.append('_method', 'PUT');
					//Enviamos la petición
					axios.post(`http://venta.test/categoria/${this.slug_categoria}`,data)
					.then(function(res){
						$('#nuevacategoria').modal('hide')
						$(document.body).removeClass('modal-open');
						$('.modal-backdrop').remove();
						EventBus.$emit('categoria-actualisar', res.data.categorium)
						metodo.reset();
					})
					.catch(function(err){
						console.log(err)
					});
				}
			},
			reset: function(){
				this.nombre = "" ;
				this.titulo = "Nuevo Producto";
				this.update = 0;
				$('#crearProducto').modal('hide');
				$(document.body).removeClass('modal-open');
				$('.modal-backdrop').remove();
			},
		}
	}
</script>