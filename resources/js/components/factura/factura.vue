<template>
	<div> 
		<div class="row">
			<div class="col-2">
			</div>
			<div class="col-8">
				<form  @submit.prevent="devolucion_producto"   class="form-group" enctype = "multipart / form-data" autocomplete="off">
					<div class="form-row align-items-center">
						<div class="row">
							<div class="col-6">
								<div class="col-auto">
									<div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text">Cod Producto</div>
										</div>
										<input type="text" required class="form-control" id="codigo_producto_de" placeholder="codigo producto" v-model="codigo_producto_de">
									</div>
								</div>
							</div>
							<div class="col-6">
								<div class="col-auto">
									<div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text">Cod Cliente</div>
										</div>
										<input type="text" required class="form-control" id="codigo_cliente_de" placeholder="Codigo Cliente" v-model="codigo_cliente_de">
									</div>
								</div>
							</div>
						</div>
						<button type="submit" hidden class="btn btn-primary mb-2">Submit</button>
					</div>
				</form> 
			</div> 
			<div class="col-2">
			</div>
		</div>
		<div id="devolcionfact" style="display: none">
			<div class="row g-0" >
				<div class="col-sm-6 col-md-3"></div>
				<div class="col-6 col-md-6">
					<div  class="alert alert-danger" role="alert">
						No se encontraron resultados con los datos obtenidos !!
					</div>
				</div>
				<div class="col-6 col-md-3"></div>
			</div>
		</div>
		<div v-if="vista == 1">
			<table class="table table-bordered">
				<thead>
					<tr align="center ">
						<th colspan="7">
							<h3>Tabla de Facturas</h3>
						</th>
						<th colspan="2">
							<div class="col-auto">
								<div class="input-group">
									<div class="input-group-prepend">
										<div class="input-group-text">N Factura</div>
									</div>
									<input 
									type="text" 
									class="form-control" 
									id="nfactura"
									v-on:keyup.enter="buscarfacturalista()">
								</div>
							</div>
							<div id="nfacturanull" style="display: none" class="alert alert-danger" role="alert">
								La Factura Ingresada No Existe !!!
							</div>
						</th>
					</tr>
					<tr align="center">
					<th scope="col">N Factura</th> 
					<th scope="col">Modo de Pago</th>
					<th scope="col">Total Factura</th>
					<th scope="col">Pago Con</th>
					<th scope="col">Cambio</th>
					<th scope="col">Saldo a Cliente</th>
					<th scope="col">cliente</th> 
					<th scope="col">Fecha</th> 
					<th scope="col">Operaciones</th>
					</tr>
				</thead> 
				<tbody> 
					<tr v-for="facturas in factura" :key="facturas.id"> 
						<td align="center">{{ facturas.nfactura}}</td>
						<td align="center">{{ facturas.modo_pago}}</td>
						<td align="center">{{$separador(facturas.total_factura)}}</td>
						<td align="center">{{$separador(facturas.pago_con)}}</td>
						<td v-if="facturas.codigo_cliente == '0'" align="center">
							{{ facturas.pago_con - facturas.total_factura}}
						</td>
						<td v-else align="center">
							0
						</td>
						<td align="center">
							{{  $separador(facturas.saldo_efectivo)}}
						</td>  
						<td align="center"> 
							<label v-bind:title="facturas.clientes.nombre">
								{{ facturas.codigo_cliente}}
							</label> 
						</td> 
						<td align="center">{{ limpiarfecha(facturas.created_at)}}</td> 
						<td align="center"> 
							<button type="button" @click="cargardatos(facturas)" class="btn btn-primary btn-sm" data-toggle="modal" data-backdrop="static" data-target="#verfactura">
							Ver
							</button>
							<button type="button" @click="imprimir('seleccion',facturas)" class="btn btn-danger btn-sm">
							<i class="fas fa-print"></i>
							</button>
						</td>
					</tr> 
				</tbody>
			</table> 
			<div id="pagination">
				<pagination
				align = "center"
				:data="paginacion" 
				@pagination-change-page="getResults">
				</pagination>
			</div>
		</div> 
		
		<div v-else>
			<table class="table table-bordered">
				<thead>
					<tr align="center ">
						<th colspan="7"><h3>Tabla de Devoluciones</h3></th>
					</tr>
					<tr align="center">
						<th scope="col">N Factura</th> 
						<th scope="col">N Producto</th>
						<th scope="col">Nombre</th>
						<th scope="col">Precio</th>
						<th scope="col">Cantidad</th>
						<th scope="col">Operaciones</th>
					</tr>
				</thead> 
				<tbody> 
					<tr v-for="devolucion in devoluciones" :key="devolucion.id">
						<td align="center">{{ devolucion.nfactura}}</td>
						<td align="center">{{ devolucion.codigo}}</td>
						<td align="center">{{ devolucion.nombre}}</td>
						<td align="center">{{ devolucion.precio}}</td>
						<td align="center">{{ devolucion.cantidades}}</td>
						<td align="center"> 
							<button type="button" @click="devolucionproducto(devolucion)" class="btn btn-primary btn-sm" data-toggle="modal" data-backdrop="static" data-target="#devoluciones">
							Devolucion
							</button>
							<button type="button" @click="cancelardevo()" class="btn btn-danger btn-sm">
								Cancelar
							</button>
						</td>
					</tr> 
				</tbody>
			</table>
			
		</div>
		<div id="seleccion" style="display: none">
			<table>
				<thead>
					<tr>
						<th>Nombre</th>
						<th>&nbsp;&nbsp;&nbsp;Precio</th>
						<th>&nbsp;&nbsp;&nbsp;cant</th>
						<th>&nbsp;&nbsp;&nbsp;total</th> 
					</tr>
				</thead>
				<th>-------------------------------</th>
				<thead>
					<tr v-for="facturaproce in facturapro" :key="facturaproce.id"> 
						<th v-if="facturaproce.nombre.length > 7">
							{{ facturaproce.nombre.substr(0,7)}}
						</th>
						<th v-else>
							{{ agregarespacio(facturaproce.nombre)}}
						</th>
						<th>&nbsp;
							{{ agregarespacio($separador(facturaproce.precio))}}
						</th>
						<th>&nbsp;&nbsp;
							{{ espaciocantidad(facturaproce.cantidades)}}
						</th>
						<th>&nbsp;&nbsp;
							{{ agregarespacio($separador(facturaproce.precio * facturaproce.cantidades)) }}
						</th> 
					</tr>
					<th>--------------------------------</th>
					<th>Total</th>
					<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$separador(totalfacimprimir)}}</th>
				</thead>
			</table>
		</div>
	</div>
</template>
<script>
import EventBus from '../../event-bus';
	export default {
		data(){
			return{
				vista:1,
				paginacion: {},
				factura:[],
				devoluciones:[],
				facturapro:{},
				totalfacimprimir:{},
				nfactura:'',
				total_factura:'',
				pago_con:'',
				saldo_efectivo:'',
				codigo_cliente_de:'',
				codigo_producto_de:'',
				vacio:0,
			}
		},
		created(){
		},
		mounted()
		{ 
			this.getResults();
		},
		methods: 
		{
			getResults(page = 1) { 
				axios
					.get('http://venta.test/factura?page=' +page)
					.then(response => {  
						//this.proveedors = response.data.proveedors.data;
						this.factura = response.data.factura.data; 
						this.paginacion = response.data.factura;
					});
			},
			limpiarfecha : function(fecha)
			{
				var fecha = fecha.split("T");
				var hora = fecha[1].split('.');
				return fecha[0]+" "+hora[0];

			},
			agregarespacio : function(cadena)
			{
				var espacios = "";
				var carateres = 7-cadena.length;
				for (let i = 0; i < carateres; i++) 
				{
					espacios += ".";
				}
				return  espacios+cadena;
			},
			espaciocantidad : function(cadena)
			{
				var espacios = "";
				var carateres = 3-cadena.length;
				for (let i = 0; i < carateres; i++) 
				{
					espacios += ".";
				}
				return cadena+espacios;
			},
			cargardatos(data)
			{
				EventBus.$emit('factura-cargarproductos',data)			
			},
			devolucionproducto(data)
			{
				EventBus.$emit('devolucion-producto',data)			
			},
			devolucion_producto: function()
        	{
				let metodo = this;
        		var codigo_cliente = $('#codigo_cliente_de').val();
        		var codigo_producto = $('#codigo_producto_de').val();
    			axios.post('http://venta.test/devolucionespro',{ 
    				codigo_cliente:codigo_cliente,
    				codigo_producto:codigo_producto,
    			})
    			.then(function(res){	
					if(res.data.devolucion.length == 0)
					{
						metodo.codigo_cliente_de = '';
						metodo.codigo_producto_de ='';
						$('#codigo_producto_de').focus();
						$("#devolcionfact").css("display", "block").fadeIn().delay(7000).fadeOut();
						metodo.vista = 1;
					}
					else
					{
						$("#devolcionfact").css("display", "none");
						metodo.devoluciones = res.data.devolucion;
						metodo.vista = 0;
					} 
				})
    			.catch(function(error){
    			 console.log(error)
    			});
        	},
			imprimir(nombre, tabla) 
			{ 
				var nombre = [nombre,tabla]
				var totalfacimpri = nombre[1].total_factura;
				var idimprimir = nombre[1].id;
				var ficha = document.getElementById(nombre[0]);
				axios.get('http://venta.test/venta/1/facturaprocesada',{ params:{ id: idimprimir } })
				.then(response => {  
				this.facturapro = response.data.facturapro;
				this.totalfacimprimir = totalfacimpri;
				setTimeout(function()
					{  
						var ventimp = window.open('', 'PRINT', 'height=400,width=600');
						ventimp.document.write('<html><head><title>' + document.title + '</title>');
						ventimp.document.write('</head><body >');
						ventimp.document.writeln( ficha.innerHTML,"<br>","&nbsp;","<br>","&nbsp;","<br>","&nbsp;","<br>","&nbsp;");
						ventimp.document.write('</body></html>');
						ventimp.document.close();
						ventimp.focus();
						ventimp.print();
						ventimp.close();
						return true;
					}, 500);
				}); 				
			},
			buscarfacturalista: function()
			{ 
				let metodo = this;
				var nfactura = $('#nfactura').val()
				if (nfactura !== "") {
					metodo.vacio = 0
					axios.post('http://venta.test/buscarnfactura',{ 
					nfactura:nfactura
					}).then(function(res)
					{  
						$('#nfactura').val('');
						if (res.data.buscarnfactura.length == 1) {
							$("#nfacturanull").css("display", "none");
							$("#pagination").css("display", "none");
							metodo.factura = res.data.buscarnfactura;
						}
						else{
							metodo.vacio = 1;
						$("#nfacturanull").css("display", "block").fadeIn().delay(4000).fadeOut();
							metodo.getResults();
							$("#pagination").css("display", "block");
						}
					})
					.catch(function(error){
						console.log(error)
					});
				}
				else{
					if (metodo.vacio == 0) {
							metodo.getResults();
							metodo.vacio = 1;
					}				
				}
			},
			cancelardevo()
			{ 
				this.codigo_cliente_de = '';
				this.codigo_producto_de = '';
				let metodo = this;
				metodo.vista = 1;
			},
		},
}

</script>

