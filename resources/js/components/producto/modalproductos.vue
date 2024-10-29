<template>
	<div>
		<!-- empiesa modal eliminar -->
		<div class="modal fade bg-dark" id="deleteProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  	<div class="modal-dialog" role="document">
		   		<div class="modal-content">
				     <div class="modal-header" align="center">
				        <h5 class="modal-title" id="exampleModalLabel">Eliminar producto</h5>
				        <button type="button"  class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				     </div>
			      	<div class="modal-body" align="center">
				       	<p>El siguiente producto será eliminado:</p> 
				       	<h5 class="modal-title">{{ nombre}} </h5>
						<div class="form-group" align="center">
							<a href="#" @click="destroyProducto()" class="btn btn-danger">Eliminar</a> 
							<a href="#" @click="reseteliminar()" class="btn btn-secondary" data-dismiss="modal">Cancelar</a>
						</div>
			     	</div>
		    	</div>
		  	</div>
		</div>
		<!-- fin modal eliminar -->
		<!-- empiesa modal editar y agregar -->
		<div class="modal fade bg-dark" id="nuevoproducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">{{ titulo }}</h5>
					<button type="button" @click="reset()" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
		      	<div class="modal-body">
					<form  @submit.prevent="guardarproducto"   class="form-group" id="formProductos" enctype = "multipart / form-data" autocomplete="off">
						<div class="form-group"> 
							<div class="input-group input-group-lg">
								<div class="input-group-prepend">
									<div for="categoria" class="input-group-text">Categoria</div>
								</div>
								<select v-model="categoria" class="form-control" id="nombre" >
									<option disabled value="">Seleccione una Categoria</option>
									<option v-for="(nombre,key) in codcategoria" :value="key">{{ nombre }}</option>
									
								</select>  
							</div>
						</div>
						<div class="form-group"> 
							<div class="input-group input-group-lg">
								<div class="input-group-prepend">
									<div for="codigo" class="input-group-text">Codigo de Barra</div>
								</div>
								<input required="required" type="text" class="form-control" id="codigo" aria-describedby="nombreHelp" placeholder="Codigo Factura" v-model="codigo">
							</div>
						</div>
						<div class="form-group"> 
							<div class="input-group input-group-lg">
								<div class="input-group-prepend">
									<div for="nombre" class="input-group-text">Nombre</div>
								</div>
								<input required="required" type="text" class="form-control" id="nombre" aria-describedby="nombreHelp" placeholder="Codigo Factura" v-model="nombre">
							</div>
						</div>
						<div class="form-group"> 
							<div class="input-group input-group-lg">
								<div class="input-group-prepend">
									<div for="precio_ini" class="input-group-text">Precio Inicial</div>
								</div>
								<input required="required" type="text" class="form-control" id="precio_ini" aria-describedby="nombreHelp" placeholder="Codigo Factura"  v-on:keyup="procesovalo()" v-model="precio_ini">
							</div>
						</div>
						<div class="form-group"> 
							<div class="input-group input-group-lg">
								<div class="input-group-prepend">
									<div for="Porcentaje" class="input-group-text">Porcentaje</div>
								</div>
								<input required="required" type="text" class="form-control" id="porcentaje" aria-describedby="Porcentaje" placeholder="Codigo Factura" v-on:keyup="procesovalo()" v-model="porcentaje">
							</div>
						</div>
						<div class="form-group"> 
							<div class="input-group input-group-lg">
								<div class="input-group-prepend">
									<div for="precio_final" class="input-group-text">Precio Final</div>
								</div>
								<input required="required" type="text" class="form-control" id="precio_final" aria-describedby="nombreHelp" placeholder="Codigo Factura" v-model="precio_final">
							</div>
						</div>
						<div class="form-group"> 
							<div class="input-group input-group-lg">
								<div class="input-group-prepend">
									<div for="imagenprod" class="input-group-text">Imagen</div>
								</div>
							<input type="file" class="form-control" name="imagenprod" id="imagenprod" aria-describedby="nombreHelp" placeholder="Codigo Factura" @change="obtenerimagen">
							</div>
						</div> 
						<div class="form-group" align="center">
							<button  class="btn btn-success">Guardar</button> 
							<button type="button" @click="reset()" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
						</div>
					</form> 
		      	</div>
		    </div>
		  </div>
		</div>
		<!-- fin modal editar y agregar -->

	</div>
</template>

<script>
import EventBus from '../../event-bus';
export default 
	{
		props: {
			codigop: String,
		},
		data(){
			return{ 
				codigo:'',
				categoria: '',
				nombre:'',
				precio_ini:'',
				porcentaje:'',
				precio_final:'', 
				imagenprod:'',
				slug_pro:'',
				update : 0,
				titulo : "Nuevo Producto",
				codcategoria:{}
			}
		},
		mounted() {
			//Asignaciones cuando se reciben las propiedades. para agregar un nuevo producto que no existe en un afactura y creada 
			if (this.codigop != undefined) 
			{
				this.codigo = this.codigop;
			}
			//evento para eliminar
			 EventBus.$on('producto-delete', data => {
	 			this.slug_pro = data.slug_pro;
	 			this.nombre = data.nombre;
			});
			 //fin
			 //evento para editar llenar datos en la modal
            /*axios.get('http://venta.test/productos').then(response => {this.codcategoria =  response.data.codcategoria })*/
			EventBus.$on('producto-categoria', data => {
				this.codcategoria = data;
			});
			EventBus.$on('producto-edit', data => {
				this.codigo = data[0].codigo;
				this.nombre = data[0].nombre;
				this.categoria = data[0].categoria.id;
				this.precio_ini = data[0].precio_ini;
				this.porcentaje = data[0].porcentaje;
				this.precio_final = data[0].precio_final; 
				this.slug_pro = data[0].slug_pro;
				this.update = 1;
				this.codcategoria = data[1];
				this.titulo = "Editar Productos";
			});
			//fin
    },
		methods: {
			obtenerimagen(e)
			{ 
				let file = e.target.files[0];
				let reader = new FileReader();
				reader.onloadend = (file) => {
				this.imagenprod = reader.result;
				}
				reader.readAsDataURL(file);
			},
			guardarproducto: function()
        	{
        		let metodo = this;
        		if (this.update==0)
        		{
        			var data = new  FormData();
							//Añadimos la imagen seleccionada
							data.append('imagenprod', this.imagenprod);
							data.append('codigo', this.codigo);
							data.append('categoria', this.categoria);
							data.append('nombre', this.nombre);
							data.append('precio_ini', this.precio_ini);
							data.append('porcentaje', this.porcentaje);
							data.append('precio_final', this.precio_final); 
							//Añadimos el método PUT dentro del formData
							// Como lo hacíamos desde un formulario simple _(no ajax)_
							data.append('_method', 'POST');
							//Enviamos la petición
							axios.post('http://venta.test/productos',data)
							.then(function(res){
								//Si recibe el nit previo vuelve al modulo de la factura
								//de lo contrario actua como si fuera el modulo de terceros.
									if (metodo.codigop == undefined) {
								//Evento para hacer la actualizacion de registros al crear registros.
								}
								else {
									//Evento para volver al modulo factura.
									EventBus.$emit('volver-factura',[false,1]);
									console.log(metodo.codigop);
								}
								$('#nuevoproducto').modal('hide')
								$(document.body).removeClass('modal-open');
								$('.modal-backdrop').remove();
								EventBus.$emit('producto-agregar', res.data.productos)
								metodo.reset(1);
							})
							.catch(function(err){
								console.log(err)
							});
        		}
        		else
        		{
        			console.log('editar');
        			var data = new  FormData(); 
							//Añadimos la imagen seleccionada 
							data.append('codigo', this.codigo);
							data.append('categoria', this.categoria);
							data.append('nombre', this.nombre);
							data.append('precio_ini', this.precio_ini);
							data.append('porcentaje', this.porcentaje);
							data.append('precio_final', this.precio_final); 
							data.append('imagenprod', this.imagenprod);
							data.append('slug_pro', this.slug_pro);
							//Añadimos el método PUT dentro del formData
							// Como lo hacíamos desde un formulario simple _(no ajax)_
								data.append('_method', 'PUT');
							//Enviamos la petición
							axios.post(`http://venta.test/productos/${this.slug_pro}`,data)
							.then(function(res){
								$('#nuevoproducto').modal('hide')
								$(document.body).removeClass('modal-open');
								$('.modal-backdrop').remove();
								EventBus.$emit('producto-actualisar',res.data.producto)
								metodo.reset();
							})
							.catch(function(err){
								console.log(err)
							});
        		}
        	},
        	procesovalo:function()
        	{
				if (this.porcentaje == "") 
				{
					this.precio_final = "0"
				}
				else
				{
					if (this.precio_ini == "") 
					{
						this.precio_final = "0"
					}
					else
					{
						var resultado = this.precio_final =parseInt(this.precio_ini)*((parseInt(this.porcentaje)/100)+1);
					}
				}
        	},
			    reset: function(flag=0){
			     	this.imagenprod = "" ;
						this.codigo = "" ;
						this.categoria = "" ;
						this.nombre = "" ;
						this.precio_ini = "" ;
						this.porcentaje = "" ;
						this.precio_final = "" ; 
						this.slug_pro = "" ;
						this.titulo = "Nuevo Producto";
						this.update = 0;
						$('#crearProducto').modal('hide');
							$(document.body).removeClass('modal-open');
						$('.modal-backdrop').remove();
						//Si recibe el nit previo vuelve al modulo de la factura
							//de lo contrario actua como si fuera el modulo de terceros.
						if (this.codigop == undefined) {
						$('.modal-backdrop').remove();
						}
						else {
							if (flag == 0)
							{
								EventBus.$emit('volver-factura',[false,0]);
							}
						}
        	},
        	destroyProducto: function(){
        		let metodo = this;
    			axios.delete('http://venta.test/productos/'+this.slug_pro). 
    			then(function(response){
        		EventBus.$emit('producto-agregar')
						metodo.reseteliminar();
    			}).catch(function(error){
    				console.log(error)
    			});
        	},
        	reseteliminar: function(){
        		this.nombre = "" ;
	 					this.slug_pro = "";
	 					$('#deleteProducto').modal('hide');
    				$(document.body).removeClass('modal-open');
						$('.modal-backdrop').remove();
        	}
 		
		}
	}
	

</script>
	<style>
		body {
		font-family: 'Avenir', Helvetica, Arial, sans-serif;
		margin: 0;
		padding: 0;
		background-color: #f3f3f3;
	}
	</style>


