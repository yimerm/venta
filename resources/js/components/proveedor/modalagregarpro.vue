<template>
	<div class="modal fade" id="nuevoproveedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">{{ titulo }}</h5>
	        <button type="button" @click="reset()" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <form  @submit.prevent="guardarproveedor"   class="form-group" id="formProductos" enctype = "multipart / form-data" autocomplete="off">
						<div class="form-group"> 
							<div class="input-group input-group-lg">
								<div class="input-group-prepend">
									<div for="nombre" class="input-group-text">Nombre De La Empresa</div>
								</div>
								<input type="text" class="form-control" id="nombre" aria-describedby="nombreHelp" placeholder="Nombre De La Empresa" v-model="nombre">
							</div>
						</div>
						<div class="form-group"> 
							<div class="input-group input-group-lg">
								<div class="input-group-prepend">
									<div for="surtidor" class="input-group-text">Nombre Del Surtidor</div>
								</div>
								<input type="text" class="form-control" id="surtidor" aria-describedby="nombreHelp" placeholder="Nombre Del Surtidor" v-model="surtidor">
							</div>
						</div>
						<div class="form-group"> 
							<div class="input-group input-group-lg">
								<div class="input-group-prepend">
									<div for="celular" class="input-group-text">Celular</div>
								</div>
								<input type="text" class="form-control" id="celular" aria-describedby="nombreHelp" placeholder="Celular" v-model="celular">
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
				surtidor: '',
				celular:'',
				slug_proveedor:'',
				update : 0,
				titulo : "Nuevo Producto",
			}
		},
		mounted() {
			EventBus.$on('proveedor-edit', data => {
			this.nombre = data.nombre;
			this.surtidor = data.surtidor;
			this.celular = data.celular;
			this.slug_proveedor = data.slug_proveedor;
			this.update = 1;
			this.titulo = "Editar Productos";
			});
    },
		methods: {
			guardarproveedor: function()
			{
				let metodo = this;
				if (this.update==0)
				{
					var data = new  FormData();
					//Añadimos la imagen seleccionada
					data.append('nombre', this.nombre);
					data.append('surtidor', this.surtidor);
					data.append('celular', this.celular);
					//Añadimos el método PUT dentro del formData
					// Como lo hacíamos desde un formulario simple _(no ajax)_
					data.append('_method', 'POST');
					//Enviamos la petición
					axios.post('http://venta.test/proveedor',data)
					.then(function(res){
						$('#nuevoproveedor').modal('hide')
						$(document.body).removeClass('modal-open');
						$('.modal-backdrop').remove();
						EventBus.$emit('proveedor-agregar', res.data.productos)
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
					data.append('surtidor', this.surtidor);
					data.append('celular', this.celular);
					data.append('slug_proveedor', this.slug_proveedor);
					//Añadimos el método PUT dentro del formData
					// Como lo hacíamos desde un formulario simple _(no ajax)_
						data.append('_method', 'PUT');
					//Enviamos la petición
					axios.post(`http://venta.test/proveedor/${this.slug_proveedor}`,data).then(function(res){ 
						console.log(res.data.proveedor);
					$('#nuevoproveedor').modal('hide')
					$(document.body).removeClass('modal-open');
					$('.modal-backdrop').remove();
					EventBus.$emit('proveedor-actualisar',res.data.proveedor);
					metodo.reset();
					})
					.catch(function(err){
						console.log(err)
					});
				}
			},
			reset: function(){
				this.nombre = "" ;
				this.surtidor = "" ;
				this.celular = "" ;
				this.titulo = "Nuevo Producto";
				this.update = 0;
				$('#crearProducto').modal('hide');
				$(document.body).removeClass('modal-open');
				$('.modal-backdrop').remove();
			},
		}
	}
	

</script>
<style>
	
</style>


