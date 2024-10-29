<template>
	<div> 
		<table class="table  table-hover table-bordered table-sm">
			<thead>
				<tr align="center">
					<th colspan="4">Listado de Proveedores</th>
					<th>
						<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-backdrop="static" data-target="#nuevoproveedor">
						  +Producto
						</button>
					</th>
				</tr>
			    <tr align="center">
					<th scope="col">Nombre De La Empresa</th>
					<th scope="col">Nombre Del Surtidor</th>
					<th scope="col">Celular</th>
			    <th scope="col">Editar</th>
			    <th scope="col">Eliminar</th>
			    </tr>
			</thead>
				<tbody>
					<tr v-for="(tablaproveedor, index) in proveedore" :key="tablaproveedor.id">
						<td align="center">{{ tablaproveedor.nombre}}</td>      
						<td align="center">{{ tablaproveedor.surtidor }}</td>
						<td align="center">{{ tablaproveedor.celular}}</td>
						<td align="center">
							<button type="button" @click="editproveedor(tablaproveedor)" class="btn btn-primary btn-sm" data-toggle="modal" data-backdrop="static" data-target="#nuevoproveedor">
								<i class="fas fa-edit"></i> 
							</button>
						</td>
						<td align="center">
							<button type="button" @click="deleteProductos(tablaproveedor)" class="btn btn-danger btn-sm" data-toggle="modal" data-backdrop="static" data-target="#deleteProducto"> 
							<i class="fas fa-trash-alt"></i>
							</button>
						</td>
					</tr>
				</tbody>
		</table>
		<pagination 
			:data="paginacionpro" 
			@pagination-change-page="getResultsProveedor"
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
				proveedore:[],
				paginacionpro: {},
			}
		},
		created(){
			EventBus.$on('proveedor-agregar', data => {  
				this.getResultsProveedor()
			}); 
			EventBus.$on('proveedor-actualisar',data =>{
				var quitar = this.proveedore.findIndex(dato => dato.id === data.id);	 
				this.proveedore.splice(quitar,1,data);
			})
		},
		mounted(){
			this.getResultsProveedor();
		},
		beforeDestroy(){
			EventBus.$off('proveedor-agregar');
			EventBus.$off('proveedor-actualisar');
		},
		methods: {
			getResultsProveedor(page = 1) 
			{
				axios.get('http://venta.test/proveedor?page=' +page)
				.then(response =>{
					this.proveedore = response.data.proveedore.data;
					this.paginacionpro = response.data.proveedore;
					})
			},
			editproveedor(data){ 
				EventBus.$emit('proveedor-edit',data)
			},
			deleteProductos(data){
			EventBus.$emit('proveedor-delete',data)
			}
		},

}
 
</script>

<style>
	.top-space{
		margin-top: 20px
	}
</style>
