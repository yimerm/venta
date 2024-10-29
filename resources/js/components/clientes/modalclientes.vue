<template>
	<div class="modal fade" id="nuevoclienteo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">{{ titulo }}</h5>
	        <button type="button" @click="reset()" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <form  @submit.prevent="guardarcliente"   class="form-group" id="formProductos" enctype = "multipart / form-data" autocomplete="off">

				<div class="form-group"> 
					<div class="input-group input-group-lg">
						<div class="input-group-prepend">
							<div for="cedula" class="input-group-text">Cedula</div>
						</div>
						<input type="text" class="form-control" id="cedula" aria-describedby="nombreHelp" placeholder="cedula i cliente" v-model="cedula">
					</div>
				</div>

				<div class="form-group"> 
					<div class="input-group input-group-lg">
						<div class="input-group-prepend">
							<div for="nombre" class="input-group-text">Nombres</div>
						</div>
						<input type="text" class="form-control" id="nombre" aria-describedby="nombreHelp" placeholder="Nombre cliente" v-model="nombre">
					</div>
				</div>

				<div class="form-group"> 
					<div class="input-group input-group-lg">
						<div class="input-group-prepend">
							<div for="apellidos" class="input-group-text">Apellidos</div>
						</div>
						<input type="text" class="form-control" id="apellidos" aria-describedby="nombreHelp" placeholder="Apellidos cliente" v-model="apellidos">
					</div>
				</div>

				<div class="form-group"> 
					<div class="input-group input-group-lg">
						<div class="input-group-prepend">
							<div for="celular" class="input-group-text">Celular</div>
						</div>
						<input type="text" class="form-control" id="celular" aria-describedby="nombreHelp" placeholder="#Celular" v-model="celular">
					</div>
				</div>

				<div class="form-group"> 
					<div class="input-group input-group-lg">
						<div class="input-group-prepend">
							<div for="direcion" class="input-group-text">Direcion</div>
						</div>
						<input type="text" class="form-control" id="direcion" aria-describedby="nombreHelp" placeholder="Direcion eje: calle 4 #55-55 barrio : centro" v-model="direcion">
					</div>
				</div>

				<div class="form-group"> 
					<div class="input-group input-group-lg">
						<div class="input-group-prepend">
							<div for="monto_deuda" class="input-group-text">Monto Afiar</div>
						</div>
						<input type="text" class="form-control" id="monto_deuda" aria-describedby="nombreHelp" placeholder="Ejemplo: 500.000 " v-model="monto_deuda">
					</div>
				</div>

				<div class="form-group"> 
					<div class="input-group input-group-lg">
						<div class="input-group-prepend">
							<div for="imagencliente" class="input-group-text">Imagen</div>
						</div>
					<input type="file" class="form-control" name="imagencliente" id="imagencliente" aria-describedby="nombreHelp" placeholder="Codigo Factura" @change="obtenerimagen">
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
			cedula:'',
			nombre:'',
			apellidos: '',
			celular:'',
			direcion:'',
			monto_deuda:'',
			imagencliente:'',
			slug_clientes:'',
			update : 0,
			titulo : "Nuevo Producto",
		}
	},
	mounted() {
		EventBus.$on('cliente-edit', data => {
			this.cedula = data.cedula;
			this.nombre = data.nombre;
			this.apellidos = data.apellidos;
			this.celular = data.celular;
			this.direcion = data.direcion;
			this.monto_deuda = data.monto_deuda;
			this.slug_clientes = data.slug_clientes;
			this.update = 1;
			this.titulo = "Editar Productos";
		});
	},
	methods: {
		obtenerimagen(e)
		{ 
			let file = e.target.files[0];
			let reader = new FileReader();
			reader.onloadend = (file) => {
				this.imagencliente = reader.result;
			}
			reader.readAsDataURL(file);
		},
		guardarcliente: function()
		{
			let metodo = this;
			if (this.update==0)
			{
				var data = new  FormData();
				//Añadimos la imagen seleccionada
				data.append('cedula', this.cedula);
				data.append('nombre', this.nombre);
				data.append('apellidos', this.apellidos);
				data.append('celular', this.celular);
				data.append('direcion', this.direcion);
				data.append('imagencliente', this.imagencliente);
				data.append('monto_deuda', this.monto_deuda);
				//Añadimos el método PUT dentro del formData
				// Como lo hacíamos desde un formulario simple _(no ajax)_
				data.append('_method', 'POST');
				//Enviamos la petición
				axios.post('http://venta.test/clientes',data)
				.then(function(res){
					$('#nuevoclienteo').modal('hide')
					$(document.body).removeClass('modal-open');
					$('.modal-backdrop').remove();
					EventBus.$emit('producto-agregar', res.data.productos)
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
				data.append('cedula', this.cedula);
				data.append('nombre', this.nombre);
				data.append('apellidos', this.apellidos);
				data.append('celular', this.celular);
				data.append('direcion', this.direcion);
				data.append('monto_deuda', this.monto_deuda);
				data.append('imagencliente', this.imagencliente);
				data.append('slug_clientes', this.slug_clientes);
				//Añadimos el método PUT dentro del formData
				// Como lo hacíamos desde un formulario simple _(no ajax)_
					data.append('_method', 'PUT');
				//Enviamos la petición
				axios.post(`http://venta.test/clientes/${this.slug_clientes}`,data)
				.then(function(res){
					 
					$('#nuevoclienteo').modal('hide')
					$(document.body).removeClass('modal-open');
					$('.modal-backdrop').remove();
					EventBus.$emit('cliente-actualisar', res.data.clientes)
					metodo.reset();
				})
				.catch(function(err){
					console.log(err)
				});

			}
		},
		reset: function()
		{
			this.cedula = "" ;
			this.nombre = "" ;
			this.apellidos = "" ;
			this.celular = "" ;
			this.direcion = "" ;
			this.imagencliente = "" ;
			this.titulo = "Nuevo Producto";
			this.update = 0;
			$('#crearProducto').modal('hide');
			$(document.body).removeClass('modal-open');
			$('.modal-backdrop').remove();
		},
	}
}
	

</script>