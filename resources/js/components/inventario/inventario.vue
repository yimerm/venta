<template>
	<div> 
		<div class="row">
			<div class="col-6">
				<div class="col-auto">
					<div class="input-group">
						<div class="input-group-prepend">
							<div class="input-group-text">N Factura</div>
						</div>
						<input 
						placeholder="Buscar Factura"
						type="text" 
						class="form-control" 
						id="nfactura"
						v-on:keyup.enter="buscarfacturalista()">
					</div>
				</div>
			</div>
			<div class="col-6" align="right">
				<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-backdrop="static" data-target="#crearinventario" @click="proveedorfactura()">
					+Cargar Factura
				</button>
				<button 
								type="button"
								class="btn btn-danger btn-sm"
								@click="getResults()">
							 <i class="fas fa-redo"></i>
							</button>
			</div>
		</div><br>
		<div id="mitoast" class="toast" style="background-color: yellow;">
			<div class="toast-header">
				<strong class="mr-auto"> Factura N-{{codigofacturae}} en proceso</strong>
				<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Cerrar" @click="cerrarToast()">
						<span aria-hidden="true">×</span>
				</button>
			</div>
		</div>
		<table class="table">
			<thead>
			    <tr align="center">
			      <th scope="col">Codigo</th>
			      <th scope="col">Proveedor</th>
			      <th scope="col">Modo de Pago</th>
			      <th scope="col">Fecha ingreso</th>
			      <th scope="col">Fecha pago</th>
			      <th scope="col">Total</th>
			      <th scope="col">Operaciones</th>
			    </tr>
			</thead> 
			<tbody> 
				<tr v-for=" proveedor in proveedors" :key="proveedor.id" v-bind:id ="proveedor.id"> 
					<td align="center">{{ proveedor.codigo}}</td>  
					<td align="center">{{ proveedor.proveedor.nombre}}</td>
					<td align="center">{{ proveedor.pago}}</td>
					<td align="center">{{ proveedor.fecha_ingreso}}</td>
					<td align="center">{{ proveedor.fecha_pago}}</td>
					<td align="center" v-bind:id= "proveedor.codigo" v-if="proveedor.inventarioproducto.length == 0 ">
						0
					</td>
					<td v-else align="center" class="" v-bind:id= "proveedor.codigo+1">
						{{$separador(proveedor.inventarioproducto[0].total)}}
					</td>
					<td align="center" v-if="proveedor.estado == 1"> 
						<div v-if="proveedor.proceso == 0">
							<button type="button" 
							id="invent"
							@click="cargardatos(proveedor,1)"
							v-bind:value="proveedor.id"
							class="btn btn-primary btn-sm">
							<i class="fas fa-dolly-flatbed"></i>
							</button>
								<button 
									type="button" 
									@click="deleteinventarios(proveedor)" 
									class="btn btn-danger btn-sm" 
									data-toggle="modal" 
									data-backdrop="static" 
									data-target="#deleteinventario">
									<i class="fas fa-trash-alt"></i>
							</button>
						</div>
						<div v-if="proveedor.proceso == 1">
							<button type="button" 
							@click="cargardatos(proveedor,1)"
								v-bind:value="proveedor.id"
								class="btn btn-dark btn-sm">
								<i class="fas fa-user-lock"></i>
								<a v-if="usuariologiado == proveedor.nom_user">
									Tu
								</a>
								<a v-else>
									{{proveedor.nom_user}}
								</a>
							</button>
						</div>
					</td>
					<td align="center" v-if="proveedor.estado == 0">
						<button type="button" @click="cargardatos(proveedor,0)" class="btn btn-success btn-sm" data-toggle="modal" data-backdrop="static" data-target="#cargardatosnuevos">
							<i class="fas fa-eye"></i>
						</button>
					</td>
					<td align="center" v-if="proveedor.estado == 2">
						<button type="button" @click="cargardatos(proveedor)" class="btn btn-danger btn-sm" data-toggle="modal" data-backdrop="static" data-target="#cargardatosnuevos">
							<i class="fas fa-user-lock"></i>
							
						</button>
					</td>
				</tr> 
			</tbody>
		</table>
		<div id="pagination">
			<pagination 
			:data="paginacion" 
				@pagination-change-page="getResults"
				align = "center"
				:limit = "2"
			>
			</pagination>
	</div>
	</div >
</template>
<script>
import EventBus from '../../event-bus';
	export default {
		data(){
			return{
				paginacion: {},
				proveedors:{},
				disponibilidad:[],
				codigo:'',
				id:'',
				fecha_pago:'',
				pago:'',
				proveedor: null,
				codprove:{},
				total_factura:'',
				codigofacturae:''
			}
		},
		created(){
			EventBus.$on('inventario-agregar', data => {	
				this.getResults();
			})
			EventBus.$on('inventario-actualisartabla',data =>{
				console.log(data[0].mostartotalnue1);
				const divtotal = document.getElementById(data[1]+1);
				divtotal.innerText=data[0].mostartotalnue1; 
			})
		},
		mounted()
		{ 
			this.getResults();
		},
		beforeDestroy(){
			EventBus.$off('inventario-agregar');
			EventBus.$off('inventario-actualisartabla');
		},
		methods: 
		{
			getResults(page = 1) {
				axios
					.get('http://venta.test/entradafactura?page=' +page)
					.then(response => { 
						this.proveedors = response.data.proveedors.data;
						this.codprove =  response.data.codprove//carga datos select para el proveedor
						this.paginacion = response.data.proveedors; 
					});
			},
			guardarinventario : function()
			{
				let metodo = this;
				axios.post('http://venta.test/entradafactura',{
					codigo: this.codigo,
					proveedor: this.proveedor
				})
				.then(function(res){
					EventBus.$emit('inventario-agregar', res.data.entradafactura) //no me esta baciando los campos
					metodo.vaciar();
				})
				.catch(function(err){
					console.log(err)
				});
			},
			vaciar: function(){ 
				this.proveedor = "" ;
				this.codigo = "" ;
			},
      proveedorfactura(){
				EventBus.$emit('proveedor-cargarfactura',this.codprove)			
			},
      cargardatos(data){
				
				let metodo = this;
				var usuariologiado = this.usuariologiado;
				axios.post('http://venta.test/verificarfactura',{ 
						faccodigo:data.codigo
					}).then(function(res)
					{ 
						var verificacion = res.data.verificacion[0].proceso
						if (verificacion == "0") {
							EventBus.$emit('producto-cargarinventario',data);
							$("#cargardatosnuevos").modal('show');
						}
						else
						{
							if (usuariologiado == res.data.verificacion[0].nom_user) {
								EventBus.$emit('producto-cargarinventario',data);
							$("#cargardatosnuevos").modal('show');
							}
							else{
								metodo.mostrarToast(data.codigo);
							metodo.getResults();
							}
							
						}
					})
					.catch(function(error){
					console.log(error)
					});	
			},
			deleteinventarios(data){
				EventBus.$emit('inventario-delete',data)
			},
			mostrarToast(data) 
			{
				this.codigofacturae = data;
				var toast = document.getElementById("mitoast");
				toast.className = "mostrar";
				setTimeout(function(){ toast.className = toast.className.replace("mostrar",""); }, 5000);
			},
 
			cerrarToast() 
			{
				var toast = document.getElementById("mitoast");
				toast.className = "cerrar";
				toast.className = toast.className.replace("cerrar","");
			},
			buscarfacturalista: function()
			{ 
				let metodo = this;
				var nfactura = $('#nfactura').val()
				var codigoenuso = this.codigoenuso;  
				axios.post('http://venta.test/buscarnfacturainventario',{ 
				nfactura:nfactura
				}).then(function(res)
				{  
					metodo.proveedors = res.data.buscarnfacturainventario;
					if (nfactura == "") {
						$("#pagination").css("display", "block");
					}
					else
					{
						$("#pagination").css("display", "none");
					}
				})
				.catch(function(error){
				console.log(error)
				});				
			}
		},
}
</script>
<style> 
 
 #mitoast {
  visibility: hidden;
  position: fixed;
  z-index: 1;
  right: 2.5%;
  top: 85%;
  max-width: 310px;
  width: 310px;
}

 
#mitoast.mostrar {
  visibility: visible;
  -webkit-animation: fadein 0.5s, fadeout 0.5s 4.6s;
  animation: fadein 0.5s, fadeout 0.5s 4.6s;
}
.border{
	border: 4px #000 solid;
}
</style>