<template>
	<div> 
		<table class="table  table-hover table-bordered table-sm">
			<thead>
				<tr align="center">
					<th colspan="2">Listado de Productos</th>
					<th colspan="1">
					<div class="row">
						<div class="col-6">
							Buscar Categoria
							<input 
							type="text" 
							class="form-control" 
							id="buscarcategoria"
							v-on:keyup="buscarcategoria()">
						</div>
						<div class="col-6">
							<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-backdrop="static" data-target="#nuevacategoria">
						  +Categoria
						</button>
						</div>
					</div> 
					</th> 
				</tr>
				<tr align="center">
					<th scope="col">Nombre</th>
					<th scope="col">Editar</th>
					<th scope="col">Eliminar</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="tablacatego in tablacategorias" :key="tablacatego.id">
					<td align="center">{{ tablacatego.nombre}}</td>      
					<td align="center">
						<a href="#" @click="editcategoria(tablacatego)" class="btn btn-primary btn-sm" data-toggle="modal" data-backdrop="static" data-target="#nuevacategoria">
							<i class="fas fa-edit"></i>
						</a>
					</td>
					<td align="center">
						
						<a href="#"  @click="deletecategoria(tablacatego)" class="btn btn-danger btn-sm" data-toggle="modal" data-backdrop="static" data-target="#deletecategoria">
							<i class="fas fa-trash-alt"></i>
						</a>
					</td>
				</tr>
			</tbody>
		</table>
		<pagination 
			:data="paginacioncategoria" 
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
				paginacioncategoria: {},
				tablacategorias:[],
			} 
		},
		created()
		{
			EventBus.$on('categoria12-tabla', data => { 
					this.getResults();
			});
			EventBus.$on('categoria-actualisar',data =>{ 
				var quitar = this.tablacategorias.findIndex(dato => dato.id === data.id);	 
				this.tablacategorias.splice(quitar,1,data);
			})
		},
		mounted(){
			this.getResults();
		},
		beforeDestroy(){
			EventBus.$off('categoria12-tabla');
		},
		methods:{
			getResults(page = 1) 
			{
				axios.get('http://venta.test/categoria?page=' +page)
				.then(response =>{
					
					this.tablacategorias = response.data.tablacategorias.data;
					this.paginacioncategoria = response.data.tablacategorias;
				})
			},
			editcategoria(data){
				EventBus.$emit('cliente-edit',data)
			},
			deletecategoria(data){
				EventBus.$emit('categoria-delete',data)
			},
			buscarcategoria: function()
			{ 
				let metodo = this;
				var nombrepro = $('#buscarcategoria').val()
				var codigoenuso = this.codigoenuso;  
				axios.post('http://venta.test/listaproducto',{ 
				nombrepro:nombrepro
				}).then(function(res)
				{  
					metodo.tablacategorias = res.data.listadoproduc;
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