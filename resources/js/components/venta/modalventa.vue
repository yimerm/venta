<template>
	<div> 
		<div class="modal fade bg-dark" id="procesarventa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  	<div class="modal-dialog" role="document">
		   		<div class="modal-content">
			      <div class="modal-body text-center" align="text-center">
			      	<form class="form-group" id="formprocesarventa" enctype = "multipart / form-data" autocomplete="off">  
								<div class="input-group-prepend">
									<div class="input-group input-group-lg">
										<div class="input-group-prepend">
											<div 
												for="codigocliente" 
												class="input-group-text">
												<h3>Modo de Pago</h3>
											</div>
										</div>
										<div class="text-center form-control">
											<button
											readonly
											type="button" 
											@click="resetfromcliente();pagos('0')"
											id="botonefectivo" 
											class="btn btn-primary" >
											Efectivo
											</button>
											<button 
											type="button"
											@click="resetfromcliente();pagos('1')" 
											id="botonacredito" 
											class="btn btn-primary" >
											Acredito
											</button>
										</div>
									</div>
								</div>
							<div id="acredito" style="display: none" >
								<div v-if="modopago == 0">
									<div class="input-group-prepend">
										<div class="input-group input-group-lg">
											<div class="input-group-prepend">
												<div 
													for="codigocliente" 
													class="input-group-text">
													<h3>Codigo Cliente</h3>
												</div>
											</div>
											<input 
											style="text-align:right; font-size:27px"
											@change="buscarcliente()" 
											v-model="codigocliente" 
											type="text"
											required ="required"
											class="text-center form-control" 
											id="codigocliente" 
											aria-describedby="nombreHelp" 
											placeholder="Codigo Cliente"   
											autofocus>
										</div>
									</div> 
									<div class=" input-group-prepend">
										<div class="input-group input-group-lg">
											<div class="input-group-prepend">
												<div 
													for="deudaactual" 
													class="input-group-text">
													<h3>Deuda Actual </h3>
												</div>
											</div> 
												<input 
												style="text-align:right; font-size:27px"
												readonly
												type="text" 
												class="form-control" 
												id="deudaactual" 
												aria-describedby="nombreHelp" 
												v-model="deudaactual" 
												autofocus> 
										</div>
									</div> 
									<div class=" input-group-prepend">
										<div class="input-group input-group-lg">
											<div class="input-group-prepend">
												<div 
													for="codigop" 
													class="input-group-text">
													<h3>Total </h3>
												</div>
											</div> 
												<input   
												style="text-align:right; color: blue; font-size:27px"
												readonly
												type="text" 
												class="form-control" 
												id="cproducto" 
												aria-describedby="nombreHelp" 
												placeholder="Codigo Producto"
												
												v-bind:value="$separador(totalfactura_venta)"   
												autofocus> 
										</div>
									</div>
									<div class=" input-group-prepend">
										<div class="input-group input-group-lg">
											<div class="input-group-prepend">
												<div 
													for="codigop" 
													class="input-group-text">
													<h3>Total Deuda</h3>
												</div>
											</div> 
												<input  
												style="text-align:right; font-size:27px"
												readonly
												type="text" 
												class="form-control" 
												id="cproducto" 
												aria-describedby="nombreHelp" 
												placeholder="Codigo Producto"
												v-model="totaldeuda" 
												autofocus> 
										</div>
									</div>
									<div class=" input-group-prepend">
										<div class="input-group input-group-lg">
											<div class="input-group-prepend">
												<div 
													for="codigop" 
													class="input-group-text">
													<h3>Limite Monto </h3>
												</div>
											</div> 
												<input  
												style="text-align:right; font-size:27px"
												readonly
												type="text" 
												class="form-control" 
												id="cproducto" 
												aria-describedby="nombreHelp" 
												placeholder="Codigo Producto"
												v-model="limitemonto"  
												autofocus> 
										</div>
									</div>
									<div style="display: none" id="montosuperadocliente" class=" input-group-prepend">
										<div class="input-group input-group-lg">
											<div class="input-group-prepend">
												<div 
													for="codigop" 
													class="input-group-text">
													<h3>Monto Superado Por</h3>
												</div>
											</div> 
												<input  
												style="color: red; text-align:right; font-size:27px"
												readonly
												type="text" 
												class="form-control" 
												id="montosuperado"   
												v-model="montosuperado"  
												autofocus> 
										</div>
									</div>
									<div style="display: none" id="saldofavorcliente" class=" input-group-prepend">
										<div class="input-group input-group-lg">
											<div class="input-group-prepend">
												<div 
													for="codigop" 
													class="input-group-text">
													<h3>Saldo a Favor</h3>
												</div>
											</div> 
												<input  
												style="color: green; text-align:right; font-size:27px"
												readonly
												type="text" 
												class="form-control" 
												id="saldoafavor" 
												v-model="saldoafavor"  
												autofocus> 
										</div>
									</div>
								</div>
							</div> 
							<div id="efectivo" style="display: block">
								<div v-if="modopago == 1">
									<div class=" input-group-prepend">
										<div class="input-group input-group-lg">
											<div class="input-group-prepend">
												<div 
													for="codigop" 
													class="input-group-text">
													<h2>Total </h2>
												</div>
											</div> 
												<input  
												style="color: blue; font-size:30px"
												readonly
												type="text" 
												class="text-center form-control" 
												id="total" 
												aria-describedby="nombreHelp" 
												placeholder="Codigo Producto"
												v-bind:value="$separador(totalfactura_venta)"   
												autofocus>  
										</div>
									</div>
									<div class="input-group-prepend">
										<div class="input-group input-group-lg">
											<div class="input-group-prepend">
												<div 
													for="codigop" 
													class="input-group-text">
													Paga Con
												</div>
											</div>
											<input
											v-on:keyup="procesovalor()"  
											@keyup.enter="saltoinput()"
											v-model="pagocon"
											style="font-size:25px" 
											type="text" 
											class="text-center form-control" 
											id="pagocon" 
											aria-describedby="nombreHelp" 
											placeholder="Ej:50.000"   
											autofocus>
										</div>
									</div> 
									<div class="input-group-prepend">
										<div class="input-group input-group-lg">
											<div class="input-group-prepend">
												<div 
													for="codigop" 
													class="input-group-text">
													Cambio
												</div>
											</div>
											<input
											v-bind:value="$separador(cambioventa)" 
											style="font-size:30px" 
											readonly 
											type="text" 
											class="text-center form-control" 
											id="cproducto" 
											aria-describedby="nombreHelp"   
											autofocus>
										</div>
									</div>
									<div id="codigo_cliente" style="display: none" class="input-group-prepend">
										<div class="input-group input-group-lg">
											<div class="input-group-prepend">
												<div 
													for="codigocliente" 
													class="input-group-text">
													<h3>Codigo Cliente</h3>
												</div>
											</div>
											<input  
											type="text"
											required="required"
											class="text-center form-control" 
											id="codigocliente" 
											aria-describedby="nombreHelp" 
											placeholder="Codigo Cliente"  
											@change="buscarcliente()" 
											v-model="codigocliente"  
											style="text-align:right; 
											font-size:27px"
											autofocus
											>
										</div>
									</div>  
								</div>
							</div>
							<div id="monto_superado" style="display: none" class="alert alert-danger" role="alert">
									El monto {{$separador(cambioventa)}} supera el limite de la cuenta !!
							</div> 
							<div id="clientenoexis" style="display: none" class="alert alert-danger" role="alert">
								Usuario no existente !!
							</div>
							<div id="clientesiexis" style="display: none" class="alert alert-success" role="alert">
								Usuario validado correctamente
							</div>
							<br>  
							<div class="form-group" align="center"> 
							
								<button
									type="button" 
									@click="procesarfacturaventa()"
									id="procesar" 
									class="btn btn-primary" >
									Procesar
								</button>
								<button 
									type="button" 
									@click="resetfromcliente()"
									class="btn btn-secondary" 
									data-dismiss="modal">
									Cancelar
								</button>
							</div>
						</form>
			     	</div>
		    	</div>
		  	</div>
		</div>
		<div class="modal" id="verificarvent">
		  	<div class="modal-dialog modal-sm modal-dialog-centered" >
		   		<div class="modal-content">
			      	<div class="modal-body" align="center">
				       	<h2>Eliminar Articulos</h2>
								<div class="form-group" align="center">
									<button type="button"  @click="destroyarticulos()" class="btn btn-danger">Eliminar</button> 
									<button type="button" @click="resetfromcliente()" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
								</div>
			     	</div>
		    	</div>
		  	</div>
		</div>
		<div class="modal fade bg-dark" id="detalleventa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-body text-center" align="text-center">
					  	<form @submit.prevent="resetsiste" class="form-group" enctype = "multipart / form-data" autocomplete="off">
							<h2>Numero de factura</h2>
							<div style="font-size:50px"> 
								# {{nufactura}}
							</div>
							<div class="form-group" align="center">
								<div v-if="modopago == 1">
									<table style="font-size:30px" class="table">
										<tbody>
											<tr>
											<th scope="row">Total Factura</th>
											<td>{{$separador(totalfactura_venta)}}</td>
											</tr>
											<tr>
												<th scope="row">Pago con</th>
												<td>
													<div v-if="pagocon == ''">
													{{$separador(totalfactura_venta)}}
													</div>
													<div v-if="pagocon > 0">
														{{$separador(pagocon)}}
													</div>
												</td>
											</tr>
											<tr>
												<th scope="row">Cambio</th>
												<td>
												<div v-if="pagocon == ''">
													0
												</div>
												<div v-else>
													<div v-if="pagocon - totalfactura_venta < -0"> 
													0
													</div>
													<div v-else>
														{{$separador(pagocon - totalfactura_venta)}} 
													</div>	
												</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div v-if="modopago == 0">
									<h3>Factura Acredito</h3>
									<table style="font-size:30px" class="table">
										<tbody>
											<tr>
												<th scope="row">Codigo Cliente</th>
												<td>{{codigocliente}}</td>
											</tr>
											<tr>
												<th scope="row">Total Factura</th>
												<td>{{$separador(totalfactura_venta)}}</td>
											</tr>
										</tbody>
									</table>
								</div>
								<button 
									type="button" 
									@click="imprimir('seleccion',nufactura);resetsiste()"  
									class="btn btn-success">
									Imprimir
								</button>
								<button 
									type="submit" 
									ref="btnfinal"
									id="botonprocesar"  
									class=" finalisarbtn btn btn-primary">
									Finalizar
								</button>
							</div>
						</form>		
			     	</div>
		    	</div>
		  	</div>
		</div>
		<div id="seleccion" style="display: none">
			<table>
				<thead >
					<tr align="center"><th>Nit : 1254000025</th></tr>
					<tr align="center"><th>Nombre Cliente : {{nomclienteimprimir}}</th></tr>
					<tr align="center"><th>Modo de pago : {{modopagoimprimir.modo_pago}}</th></tr>
					<tr align="center"><th>fecha : {{fechaactual}}</th></tr>
					<tr align="center"><th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Num factura</th></tr>
					<tr align="center"><th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{nufactura}}</th></tr>
					<th>--------------------------------</th>
					<tr>
						<th>Nombre</th>
						<th>&nbsp;&nbsp;&nbsp;Precio</th>
						<th>&nbsp;&nbsp;&nbsp;cant</th>
						<th>&nbsp;&nbsp;&nbsp;total</th> 
					</tr>
				</thead>
				<th>--------------------------------</th>
				<thead>
					<tr v-for="imprimirfact in imprimirfacturan" :key="imprimirfact.id"> 
						<th v-if="imprimirfact.nombre.length > 7">
							{{ imprimirfact.nombre.substr(0,7)}}
						</th>
						<th v-else>
							{{ agregarespacio(imprimirfact.nombre)}}
						</th>
						<th>&nbsp;
							{{ agregarespacio($separador(imprimirfact.precio))}}
						</th>
						<th>&nbsp;&nbsp;
							{{ espaciocantidad(imprimirfact.cantidades)}}
						</th>
						<th>&nbsp;&nbsp;
							{{ agregarespacio($separador(imprimirfact.precio * imprimirfact.cantidades)) }}
						</th> 
					</tr>
					<th>--------------------------------</th>
					<tr>
						<th>
							Total:{{$separador(modopagoimprimir.total_factura)}}
						</th>
					</tr>
					<tr>
						<th>
							pago con:{{$separador(modopagoimprimir.pago_con)}}
						</th>
					</tr>
					<tr>
						<th>
							<div v-if="nomclienteimprimir === 'efectivo'">
								cambio:{{$separador(modopagoimprimir.pago_con - modopagoimprimir.total_factura)}}
							</div>
							<div v-else>
								A cuenta:{{$separador(modopagoimprimir.saldo_efectivo)}}
							</div>
						</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</template>
<script>
	import EventBus from '../../event-bus';
export default 
	{
		data(){
			return{
				nufactura:'',
				codigoenuso:'',
				totalfactura_venta:'',
				totalventa:'',
				pagocon:'',
				cambioventa:'',
				clientes:null,
				imprimirfacturan:{},
				nomclienteimprimir:{},
				modopagoimprimir:{},
				fechaactual:'',
				/*datos del cliente para cargar monto d la factura*/
				codigocliente:'0',
				deudaactual:'',
				totaldeuda:'',
				limitemonto:'',
				montosuperado:'',
				saldoafavor:'',
				/*fin cliente*/
				modopago:1,
				modopagomontosuperado:1,
				usuariocliente:{}
			}
		},
		created()
		{
			EventBus.$on('modalventas', data => { 
				let metodo = this;
				metodo.modopago1();
				setTimeout(function()
				{  
					$('#pagocon').focus(); 
				}, 650);
				document.getElementById("pagocon").disabled = false;
				this.totalfactura_venta = data[0];
				this.codigoenuso = data[1]; 
			});
			EventBus.$on('nfacturaventa', data => {
	 			this.nufactura = data.nufactura;				 
			});
			EventBus.$on('verificarventamodal', data => { 
				this.codigoenuso = data[0]; 
			});
		},
		mounted(){
		},
		methods: 
		{
			saltoinput:function(){
				var pagocon = $('#pagocon').val();
				if (pagocon == "") 
				{
					$('#procesar').focus()
				}
				else
				{
					$('#codigocliente').focus()
				}				
			},
			procesovalor:function()
      {  				
				var pagocon = $('#pagocon').val();  
        if (pagocon == "") 
				{
					this.cambioventa = "0";
				}
				else
				{
					this.cambioventa = parseInt(pagocon)- parseInt(this.totalfactura_venta); 
					$("#montosuperadocliente").css("display", "block");
				} 
				//condicion para mostar div si el pagocon es menor al total de venta
				if (this.cambioventa == 0) 
				{
					$("#codigo_cliente").css("display", "none");
				}
				if (this.cambioventa < 0) 
				{ 
					$("#codigo_cliente").css("display", "block");
					this.codigocliente = ""
				}
				else
				{
					$("#codigo_cliente").css("display", "none");
					this.codigocliente = "0"
				}
      },
			pagos: function(modopago){
				let metodo = this;
				if(modopago=='1')
				{
					metodo.modopago0();
				}
				else
				{
					metodo.modopago1();
				}
				
			},
			buscarcliente: function()
			{
				let metodo = this; 
				let codigocliente = $('#codigocliente').val()
				var totalfactura_venta = this.totalfactura_venta 
				axios.get('http://venta.test/clientes/'+codigocliente)
				.then(function(response)
				{
					var numerocliente = response.data.codigocliente.length;
					if (numerocliente == 0) 
					{
						metodo.deudaactual = "";
						metodo.limitemonto = "";
						metodo.totaldeuda = "";	
						$("#saldofavorcliente").css("display", "none");		
						$("#montosuperadocliente").css("display", "none");
						$("#clientesiexis").css("display", "none");
						$("#clientenoexis").css("display", "block");		
						document.getElementById("procesar").disabled = true;		
					}
					else
					{
						$("#clientenoexis").css("display", "none");
						$("#clientesiexis").css("display", "block");
						
						if (metodo.modopago == 1) {
							document.getElementById("procesar").disabled = false;
							document.getElementById("pagocon").disabled = true;
							document.getElementById("codigocliente").disabled  = true; 
							document.getElementById("procesar").focus();
						}
						else{
							// deudaactualcliente sin el metodo $separador 
							var deudaactualcliente = response.data.codigocliente[0].monto_deuda;
							// limitemontocliente sin el metodo $separador
							var limitemontocliente = response.data.codigocliente[0].lim_max_deuda;
							// totaldeudacliente sin el metodo $separador
							var totaldeudacliente = totalfactura_venta + Number(deudaactualcliente);
							// montosuperado sin el metodo $separador
							var montosuperadocliente = Number(limitemontocliente) - Number(totaldeudacliente); 
							metodo.deudaactual = metodo.$separador(response.data.codigocliente[0].monto_deuda);
							metodo.limitemonto = metodo.$separador(response.data.codigocliente[0].lim_max_deuda);
							metodo.totaldeuda = metodo.$separador(totalfactura_venta + Number(deudaactualcliente));
							metodo.montosuperado = metodo.$separador(Number(limitemontocliente) - Number(totaldeudacliente));
							metodo.saldoafavor = metodo.montosuperado;
							if (totaldeudacliente > limitemontocliente) 
							{
								$("#montosuperadocliente").css("display", "block");
								document.getElementById("procesar").disabled = true;		
							}
							else
							{
								$("#saldofavorcliente").css("display", "block");
								document.getElementById("procesar").disabled = false;
								document.getElementById("codigocliente").disabled  = true; 
								document.getElementById("procesar").focus();
							}
						}
					}
				})
				.catch(function(error){
				console.log(error)
				});
			},
			destroyarticulos: function()
			{
				var codigoenuso = this.codigoenuso
				console.log(codigoenuso);
				axios.post('http://venta.test/borrararticuloventa',{ 
				codigoenuso:codigoenuso
				})
				.then(function(res){
					$("#verificarvent").modal('hide'); 
					EventBus.$emit('lipiarcontedino',res.data);
					
				})
				.catch(function(error){
				console.log(error)
				});
			},
			procesarfacturaventa: function()
			{
				let metodo = this;
				var monto_deuda = this.deudaactual;
				var codigo_cliente = $('#codigocliente').val()
				var modopago = this.modopago
				var totalfactura_venta = this.totalfactura_venta 
				var codigoenuso = this.codigoenuso 
				var pagocon = $('#pagocon').val() 
				axios.post('http://venta.test/procesarfacturaventa',{ 
				totalfactura_venta:totalfactura_venta,
				codigoenuso:codigoenuso,
				pagocon:pagocon,
				modopago:modopago,
				codigo_cliente:codigo_cliente,
				monto_deuda:monto_deuda
				})
				.then(function(res){
					if(res.data.nufactura == 'no')
					{
						document.getElementById("procesar").disabled = false;
						$("#saldofavorcliente").css("display", "none");		
						$("#montosuperadocliente").css("display", "none");
						$("#clientenoexis").css("display", "block");		
						document.getElementById("procesar").disabled = true;
					}
					else
					{
						if (res.data == "monto") 
						{
							metodo.codigo_cliente = "";
							$("#monto_superado").css("display", "block");
						}
						else
						{
							$("#detalleventa").modal('show');
							EventBus.$emit('nfacturaventa',res.data);
							EventBus.$emit('lipiarcontedino',res.data);
						}
						metodo.saldoafavor = metodo.montosuperado;
						$("#clientenoexis").css("display", "none");
					}
				})
				.catch(function(error){
				console.log(error)
				});
			},
			modaldetalleventa()
			{ 
				EventBus.$emit('modalventas',[this.totalfactura_venta,this.codigoenuso]);
					$("#procesarventa").modal('show');
			},
			verificarventamodal()
			{ 
				
				EventBus.$emit('verificarventamodal',[this.codigoenuso]);
					$("#verificarvent").modal('show');
			},
			imprimir(nombre, tabla) 
			{
				var fechaactual = new Date();
				var nombre = [nombre,tabla]
				var nfactura = nombre[1]; 
				var ficha = document.getElementById(nombre[0]);
				axios.get('http://venta.test/venta/1/imprimirfacturan',{ params:{ nfactura: nfactura } })
				.then(response => {  
					this.fechaactual = fechaactual.toLocaleDateString() +' '+ fechaactual.getHours() +':' + fechaactual.getMinutes();
					this.modopagoimprimir = response.data.numerofactura;
					this.nomclienteimprimir = response.data.nomcliente;
					this.imprimirfacturan = response.data.imprimirfactura;
				setTimeout(function()
					{  
						var ventimp = window.open('', 'PRINT', 'height=400,width=600,scrollbars=NO,resizable=NO,atributo=NO');
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
      resetsiste: function()
      { 
				let metodo = this; 
        $('#procesarventa').modal('hide');
        $('#verificarvent').modal('hide');
        $('#detalleventa').modal('hide');
        $(document.body).removeClass('modal-open');
        $('.modal-backdrop').remove();
				metodo.resetfromcliente();
      },
      resetfromcliente: function()
      {
				$("#acredito").css("display", "none");
				$("#codigo_cliente").css("display", "none");
				$("#efectivo").css("display", "block");
				$("#clientesiexis").css("display", "none");
				$("#clientenoexis").css("display", "none");
				$("#monto_superado").css("display", "none");
        $("#montosuperadocliente").css("display", "none");
        $("#saldofavorcliente").css("display", "none");
        this.modopago = 1;
        this.deudaactual = "" ;
        this.totaldeuda = "" ;
        this.limitemonto = "" ;
        this.montosuperado = "" ;
        this.saldoafavor = "" ;
        this.codigocliente= "0";
        this.pagocon= "";
        this.cambioventa= "";
				document.getElementById("procesar").disabled = true;
      },
			modopago0: function(){
				this.modopago = 0;
					this.codigocliente = "";
					$("#monto_superado").css("display", "none");
					$("#clientesiexis").css("display", "none");
					$("#acredito").css("display", "block");
					$("#clientenoexis").css("display", "none"); 
					setTimeout(function()
					{  
						$('#codigocliente').focus(); 
					}, 120);
					document.getElementById("procesar").disabled = true;
					document.getElementById("botonefectivo").disabled = false;
					document.getElementById("botonacredito").disabled = true;
			},
			modopago1: function(){
					this.modopago = 1;
					setTimeout(function()
					{  
						$('#pagocon').focus(); 
					}, 120);
					this.codigocliente = "0";
					$("#clientenoexis").css("display", "none");
					$("#monto_superado").css("display", "none");
					$("#clientesiexis").css("display", "none");
					document.getElementById("codigocliente").disabled = false;
					document.getElementById("botonefectivo").disabled = true;
					document.getElementById("botonacredito").disabled = false;
					document.getElementById("procesar").disabled = false; 
			},

		},

	}
</script>	