  <template>
	<div>  
		<table class="table  table-hover table-bordered table-sm">
			<thead>
				<tr align="center">
					<th colspan="8">Listado de Productos</th>
					<th>
						Buscar Producto
						<input 
						type="text" 
						class="form-control" 
						id="buscarproductolista"
						v-on:keyup="buscarproductolista()">
					</th>
					<th>
						<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-backdrop="static" data-target="#nuevoproducto"
						@click="categoriasP()">
						  +Producto
						</button>
						<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-backdrop="static" data-target="#nuevacategoria">
						  +Categoria
						</button>
					</th>
				</tr>
			    <tr align="center">
			      <th scope="col">Imagen</th>
			      <th scope="col">Codigo</th>
			      <th scope="col">Nombre</th>
			      <th scope="col">Categoria</th>
			      <th scope="col">Precio Factura</th>
			      <th scope="col">Porcentage</th>
			      <th scope="col">Precio Venta</th>
			      <th scope="col">Cantidades</th>
			      <th scope="col">Editar</th>
			      <th scope="col">Eliminar</th>
			    </tr>
			</thead>
				<tbody>
					<tr v-for="tablaprods in tablaprod" :key="tablaprods.id">
						<td align="center"><img :src="'imagenes/'+ tablaprods.imagenprod" class="img-responsive" height="50" width="70"></td> 
						<td align="center">{{ tablaprods.codigo}}</td>      
						<td align="center">{{ tablaprods.nombre }}</td>
						<td align="center">{{ tablaprods.categoria.nombre}}</td>
						<td align="center">{{ tablaprods.precio_ini }}</td>
						<td align="center">{{ tablaprods.porcentaje }}</td>
						<td align="center">{{ tablaprods.precio_final }}</td>
						<td align="center">{{ tablaprods.cantidades }}</td>
						<td align="center">
							<a href="#" @click="editProductos(tablaprods)" class="btn btn-primary btn-sm" data-toggle="modal" data-backdrop="static" data-target="#nuevoproducto">
								<i class="fas fa-edit"></i> 
							</a>
						</td>
						<td align="center">
							<a href="#" @click="deleteProductos(tablaprods)" class="btn btn-danger btn-sm" data-toggle="modal" data-backdrop="static" data-target="#deleteProducto"> 
							<i class="fas fa-trash-alt"></i>
							</a>
						</td>
					</tr>
				</tbody>
    </table>
		<pagination 
			:data="paginacion" 
			@pagination-change-page="getResultsProducto"
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
				tablaprod:{},
				codcategoria:{},
			}
		},
		created(){
			EventBus.$on('producto-agregar', data => { 
				this.getResultsProducto();
			});
			EventBus.$on('producto-actualisar',data =>{
				var quitar = this.tablaprod.findIndex(dato => dato.id === data.id);	 
				this.tablaprod.splice(quitar,1,data);
			})
		},
		mounted()
		{
			this.getResultsProducto();
		},
		beforeDestroy(){
			EventBus.$off('producto-agregar');
			EventBus.$off('producto-actualisar');
		},
		methods: {
			getResultsProducto(page = 1) {
				axios
					.get('http://venta.test/productos?page=' +page)
					.then(response => { 
						this.tablaprod = response.data.tablaprod.data;
						this.paginacion = response.data.tablaprod;
						this.codcategoria = response.data.codcategoria;
					});
			},
			editProductos(data){
			EventBus.$emit('producto-edit',[data,this.codcategoria])
			},
			deleteProductos(data){
			EventBus.$emit('producto-delete',data)
			},
			categoriasP(){
			EventBus.$emit('producto-categoria',this.codcategoria)
			},
			buscarproductolista: function()
			{
				let metodo = this;
				var nombrepro = $('#buscarproductolista').val()
				var codigoenuso = this.codigoenuso;  
				axios.post('http://venta.test/listaproducto',{ 
				nombrepro:nombrepro
				}).then(function(res)
				{  
					metodo.tablaprod = res.data.listadoproduc;
				})
				.catch(function(error){
				console.log(error)
				});
			},
		},
}
</script>
<style>
	.top-space{
		margin-top: 20px
	}
</style>