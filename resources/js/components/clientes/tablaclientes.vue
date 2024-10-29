<template>
	<div> 
		<table class="table  table-hover table-bordered table-sm">
			<thead>
				<tr align="center">
					<th colspan="8">Listado de Productos</th>
					<th>
						<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-backdrop="static" data-target="#nuevoclienteo">
						  +Cliente
						</button>
					</th>
				</tr>
			    <tr align="center">
				  <th scope="col">Imagen</th>
				  <th scope="col">Cedula</th>
				  <th scope="col">Nombre</th>
				  <th scope="col">Apellido</th>
				  <th scope="col">Celular</th>
				  <th scope="col">Direcion</th>
				  <th scope="col">Deuda actual</th>
				  <th scope="col">Monto Maximo deuda</th>
			      <th scope="col">Editar</th>
			      <th scope="col">Eliminar</th>
			    </tr>
			</thead>
				<tbody>
					<tr v-for="tablacliente in tablaclientes" :key="tablacliente.id">
						<td align="center"><img :src="'imagenes/clientes/'+ tablacliente.imagencliente" class="img-responsive" height="50" width="70"></td> 
						<td align="center">{{ tablacliente.cedula}}</td>
						<td align="center">{{ tablacliente.nombre}}</td>      
						<td align="center">{{ tablacliente.apellidos}}</td>
						<td align="center">{{ tablacliente.celular}}</td>
						<td align="center">{{ tablacliente.direcion }}</td>
						<td align="center">{{ tablacliente.monto_deuda}}</td>
						<td align="center">{{ tablacliente.lim_max_deuda}}</td> 
						<td align="center">
							<button type="button" @click="editProductos(tablacliente)" class="btn btn-primary btn-sm" data-toggle="modal" data-backdrop="static" data-target="#nuevoclienteo">
								<i class="fas fa-edit"></i>
							</button>
						</td>
						<td align="center">
							<button type="button" @click="deletecliente(tablacliente)" class="btn btn-danger btn-sm" data-toggle="modal" data-backdrop="static" data-target="#deleteProducto"> 
							<i class="fas fa-trash-alt"></i>
							</button>
						</td>
					</tr>
				</tbody>
		</table>
		<pagination 
			:data="paginacion" 
			@pagination-change-page="getResults"
			align = "center"
			:limit = "2"
		>
		</pagination>
	</div>
</template>
<script>
import EventBus from '../../event-bus';
export default {
	data(){
		return{
			paginacion: {},
			tablaclientes:[]
		}
	},
	created(){
		EventBus.$on('cliente-agregar', data => { 
			this.getResults();
		});
		EventBus.$on('cliente-actualisar',data =>{  
			var quitar = this.tablaclientes.findIndex(dato => dato.id === data.id);	 
			this.tablaclientes.splice(quitar,1,data);
		})
	},
	mounted(){
		this.getResults();
	},
	beforeDestroy(){
		EventBus.$off('cliente-agregar');
		EventBus.$off('cliente-actualisar');
	},
	methods: {
		getResults(page = 1) {
			axios.get('http://venta.test/clientes?page=' +page)
			.then(response =>{
				this.tablaclientes = response.data.tablaclientes.data;
				this.paginacion = response.data.tablaclientes;
			})
		},
		editProductos(data){
		EventBus.$emit('cliente-edit',data)
		},
		deletecliente(data){
		EventBus.$emit('cliente-delete',data)
		}
	},
}
</script>
<style>
	.top-space{
		margin-top: 20px
	}
</style>