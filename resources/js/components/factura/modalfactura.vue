<template>
   <div>
        <div class="modal show bg-dark" id="verfactura" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		   	<div class="modal-dialog modal-lg" role="document">
		   		<div class="modal-content" align="center">
			      	<div class="modal-body" align="center">
						<div style="height: 310px; overflow: auto;">
							<table class="table  table-hover table-bordered table-sm">
								<thead style="position: sticky; top: 0; z-index: 1; background-color: #eee;">
									<tr align="center">
										<th scope="col">Codigo</th>
										<th scope="col">Nombre</th>
										<th scope="col">Precio</th>
										<th scope="col">cantidad</th>
										<th scope="col">total</th> 
									</tr>
								</thead>
								<tbody> 
									<tr v-for="facturaproce in facturapro" :key="facturaproce.id"> 
										<td align="center">
											<input 
											type="hidden" 
											id="codigo_producto"  
											v-bind:value="facturaproce.codigo">
											<h6>{{ facturaproce.codigo}}</h6>
										</td>
										<td align="center" > 
											<h5>{{ facturaproce.nombre}} </h5>
										</td>
										<td align="center">
											<h6>{{ $separador(facturaproce.precio)}}</h6>
										</td>
										<td align="center">
											<h6>{{ facturaproce.cantidades}}</h6>
										</td>
										<td align="center">
											{{ $separador(facturaproce.precio * facturaproce.cantidades) }}
										</td> 
									</tr>
								</tbody>
							</table>
						</div><br>
							<div class="row">
								<div class="col-8"> 	
									<div class="row botonesss">
										<div class="col-6">	
											<h4 class="modal-title">Cliente:{{cliente}} </h4>
											<h4 class="modal-title">Codigo:{{codigocliente}}</h4>
										</div>
										<div class="col-6">	
											<h4 class="modal-title">Total Factura:{{ $separador(totalfactura)}}</h4>
											<h4 class="modal-title">Total Productos:{{ totalproducto_venta}}</h4>
										</div>									
									</div>
									<div class="row botoness">
										<div align="center" class="col-12"> 
											<button 
											@click="pdfFacturaVentas(numerofactura)" 
											class="btn  btn-primary ">
											<i class="fas fa-download fa-sm text-white-150"></i>PDF
											</button>
											<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>	
										</div>
									</div>	
									
								</div>
								<div>
								</div>
								<div class="col-4"> 						
									<table style="font-size:13px;text-align: right;" class="table">
										<tbody>
											<tr>
												<th id="titulo">Total Factura</th>
												<div>	
													<td>{{$separador(totalfactura)}}</td>
												</div>
											</tr>
											<tr>
												<th id="titulo">Pago con</th>
												<div>
													<div v-if="modo_pago == 'efectivo'">
														<td>{{$separador(pago_con)}}</td>
													</div> 
													
												</div>
											</tr>
											<tr>
												<th id="titulo">Cambio</th>
												<div v-if="modo_pago === 'efectivo' && codigocliente === 1">
													<td>{{$separador(pago_con - totalfactura)}}</td>
												</div> 
											</tr>
											<tr>
												<th id="titulo">Saldo cliente</th>
												<div v-if="codigocliente !== 1">
													<td>{{$separador(totalfactura)}}</td>
												</div>
											</tr> 
										</tbody>
									</table>
								</div>
							</div>
			     	   </div>
		      	</div>
		  	   </div>
		   </div>
		<div class="modal show bg-dark" id="devoluciones" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  	<div class="modal-dialog modal-lg" role="document">
		   		<div class="modal-content" align="center">
			      	<div class="modal-body" align="center">
						<form  @submit.prevent="facturafinal" class="form-group" enctype = "multipart / form-data" autocomplete="off">
							<div class="row">
								<div class="col-12"> 						
									<table style="" class="table ">
										<tbody>
											<tr align="center ">
												<th colspan="2"><h3>Proceso Final Devolucion</h3></th>
											</tr>
											<tr>
												<th id="titulo">Cliente</th>
												<th>{{clienteDevolucion}}--{{codigocliDevolucion}}</th>
											</tr>
											<tr>
												<th id="titulo">Codigo Producto</th>
												<th>{{codigoproDevolucion}}</th>
											</tr>
											<tr>
												<th id="titulo">Nombre Producto</th>
												<th>{{ productoDevolucion}}</th>
											</tr>
											<tr>
												<th id="titulo">Cantidad</th>
												<th>{{ cantidadDevolucion}}</th>
											</tr> 
											<tr>
												<th id="titulo">Precio</th>
												<th>{{$separador(precioDevolucion)}}</th>
											</tr>
											<tr align="center ">
												<th colspan="2">
													<div class="row">
														<div id="input" class="col-6"> 
															<div class="col-auto">
																<div class="input-group">
																	<div class="input-group-prepend">
																		<div class="input-group-text">Cantidad</div>
																	</div>
																	<div class="col-xs-2">
																		<input type="number" 
																		v-on:keyup="cantidad()" 
																		limit = 1
																		required 
																		class="form-control" 
                                    id="cantidadesDevolucion" 
                                    placeholder="Cantidad a Devolver" v-model="cantidadesDevolucion"
																		value="1">
																	</div>
																</div>
															</div>
														</div>
														<div class="col-6"> 
															<button 
															id="procesardevolu" 
															disabled
															type="submit" 
															class="btn btn-primary">
																Confirmar
															</button>
															<button type="button"
															class="btn btn-secondary" 
															data-dismiss="modal" 
															@click="reset()">
																Cancelar
															</button>
														</div>
													</div><br>
													<div id="cantidaddevol" style="display: none">
														<div class="row g-0" >
															<div class="col-sm-6 col-md-3"></div>
															<div class="col-6 col-md-6">
																<div  class="alert alert-danger" role="alert">
																	La cantidad ingresada no es valida !!
																</div>
															</div>
															<div class="col-6 col-md-3"></div>
														</div>
													</div>
												</th>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</form>
			     	</div>
		    	</div>
		  	</div>
		</div>
   </div>
</template>

<script>
	import EventBus from '../../event-bus';
export default 
{
    data()
    {
        return{
			nprimo:'',
			cliente: '',
			totalfactura: '',
			codigocliente: '',
			id:'', 
			pago_con:'',
			modo_pago:'',
			numerofactura:'',
			facturapro:{},
			totalproducto_venta:{},
			//devolucion
			clienteDevolucion:'',
			codigocliDevolucion:'',
			codigoproDevolucion:'',
			productoDevolucion:'',
			precioDevolucion:'',
			cantidadDevolucion:'',
			cantidadesDevolucion:'',
			nfactura:'',
        }
    },
    created()
    {
        
    },
    mounted() 
    {
        EventBus.$on('factura-cargarproductos', data => 
		{
			this.cliente = data.clientes.nombre;
			this.totalfactura = data.total_factura;
			this.codigocliente = data.codigo_cliente;
			this.id = data.id;
			this.pago_con = data.pago_con;
			this.modo_pago = data.modo_pago;
			this.numerofactura = data.nfactura;
			this.facturaprocesada();
		});
		EventBus.$on('devolucion-producto', data => 
		{
			this.clienteDevolucion = data.ncliente;
			this.codigocliDevolucion = data.cedula;
			this.codigoproDevolucion = data.codigo;
			this.productoDevolucion = data.nombre;
			this.precioDevolucion = data.precio;
			this.cantidadDevolucion = data.cantidades;
			this.nfactura = data.nfactura;
		});
    },
    methods: 
    {
		//nueva funcion 
		pdfFacturaVentas : function(data)
		{
			var numerofacturas = data; 
			var nombrecliente = this.cliente;
			window.location.href = 'http://venta.test/venta/1/pdffacturaventa?numerofactura='+ numerofacturas + '&nombrecliente='+nombrecliente
		},
		facturaprocesada : function()
		{
			axios.get('http://venta.test/venta/1/facturaprocesada',{ params:{ id: this.id, }})
			.then(response => {  
				this.facturapro = response.data.facturapro;
				this.totalproducto_venta = response.data.totalproducto_venta;
			});
		},
		facturafinal : function()
		{
			var cliented = this.clienteDevolucion;
			var codigocliented = this.codigocliDevolucion;
			var codigoprod = this.codigoproDevolucion;
			var productod = this.productoDevolucion;
			var preciod = this.precioDevolucion;
			var cantidadinput = this.cantidadesDevolucion;
			var nfactura = this.nfactura;
			axios.post('http://venta.test/venta/1/devolucionprod',{ 
				cliented:cliented,
				codigocliented:codigocliented,
				codigoprod:codigoprod,
				productod:productod,
				preciod:preciod,
				cantidadinput:cantidadinput,
				nfactura:nfactura,
			})
			.then(function(res){ 
				document.getElementById("cantidadesDevolucion").value = '';
				$('#devoluciones').modal('hide');
				$(document.body).removeClass('modal-open');
				$('.modal-backdrop').remove();
			})
			.catch(function(error){
			console.log(error)
			});
		},
		cantidad()
		{
			var cantidad = $('#cantidadesDevolucion').val();  
			var cantidadfactura = Number(this.cantidadDevolucion);
			if(cantidad == '')
			{ 
				document.getElementById("cantidaddevol").style.display = "none"; 
				document.getElementById("procesardevolu").disabled = true;
			}
			else
			{
				if (cantidad > cantidadfactura) 
				{
					document.getElementById("procesardevolu").disabled = true;
					document.getElementById("cantidaddevol").style.display = "block";
				}
				else
				{
					if(cantidad == 0)
					{ 
						document.getElementById("procesardevolu").disabled = true;
						document.getElementById("cantidaddevol").style.display = "block";
					}
					else
					{ 
						document.getElementById("cantidaddevol").style.display = "none"; 
						document.getElementById("procesardevolu").disabled = false;
					}
					
				} 
			}
		},
		reset()
		{
			this.clienteDevolucion = '';
			this.codigocliDevolucion = '';
			this.codigoproDevolucion = '';
			this.productoDevolucion = '';
			this.precioDevolucion = '';
			this.cantidadDevolucion = '';
			this.cantidadesDevolucion = '';
			document.getElementById("cantidadesDevolucion").disabled = false;
		},
		

    }
}
</script>
<style >
#titulo 
{
	text-align:justify;
} 
.botoness{
	position: relative;
	top: 50px;
	height: 20px;
}
</style>