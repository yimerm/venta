<template>
	<div>
		<div class="modal show bg-dark" id="crearinventario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content" align="center">
					<div class="modal-header" >
							<h5 class="modal-title col-11 text-center">Crear Factura</h5>
					</div>
					<div class="modal-body" align="center">
						<form @submit.prevent="guardarinventario()" class="form-group" id="formProductos" autocomplete="off">
							<div class="form-group"> 
								<div class="input-group input-group-lg">
									<div class="input-group-prepend">
										<div for="codigo" class="input-group-text">Codigo factura</div>
									</div>
									<input type="text" class="form-control" id="codigoo" aria-describedby="nombreHelp" placeholder="Codigo Factura" v-model="codigo" required="required">
								</div>
							</div>
							<input hidden="hidden" type="text" class="form-control" id="pago" aria-describedby="nombreHelp" placeholder="Codigo Factura" v-model="pago">
							<input hidden="hidden" type="text" class="form-control" id="fecha_pago" aria-describedby="nombreHelp" placeholder="Codigo Factura" v-model="fecha_pago">
							<div class="form-group"> 
								<div class="input-group input-group-lg">
									<div class="input-group-prepend">
										<div for="categoria" class="input-group-text">Proveedor</div>
									</div>
									<select v-model="proveedor" name="selec" class="form-control" id="nombre" required>
										<option disabled value="" name="selec">Seleccione una Categoria</option>
										<option v-for="(nombre,key) in codprove" :value="key" name="selec"  :key="nombre.id">
											{{ nombre }}
										</option>
									</select>
								</div>
							</div>
							<div class="form-group"> 
								<div class="input-group input-group-lg">
									<div class="input-group-prepend">
										<div for="total_factura" class="input-group-text">Monto a pagar</div>
									</div>
									<input type="text" class="form-control" id="total_factura" aria-describedby="nombreHelp" placeholder="Ejemplo 500.000" v-model="total_factura" required="required">
								</div>
							</div>
							<div class="form-group"> 
								<div class="input-group input-group-lg">
									<div class="input-group-prepend">
										<div 
										for="categoria" 
										class="input-group-text">
											Modo de Pago
										</div>
									</div> 
									<div class="formulario">
										<div class="radio">    
											<input
											class="form-check-input"
											type="radio"
											name="gridRadios"
											id="gridRadios1"
											value="option1"
											@click="pagos('0')"
											>
											<label 
											class="form-check-label"
											for="gridRadios1">
												Efectivo
											</label> 
											<input 
											class="form-check-input"
											type="radio"
											name="gridRadios"
											id="gridRadios2"
											value="option2"
											@click="pagos('1')" 
											>
											<label
											class="form-check-label"
											for="gridRadios2">
												Acredito
											</label> 
										</div> 
									</div>  
								</div>
							</div>
							<div v-if="modopago == 0">
								<div class="modal-header" >
											<h5 class="modal-title col-11 text-center">
											Ingresar Fecha de Pago
										</h5>
									</div>
								<input  
									type="Date"   
									required 
									class="form-control" 
									id="fecha_pago" 
									aria-describedby="nombreHelp"  
									v-model="fecha_pago">
							</div>
							<br>
							<button type="submit" id="boton_guardar" class="btn btn-success" disabled>Guardar</button>
							<button type="button" @click="reset()" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="modal bg-dark" id="deleteinventario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  	<div class="modal-dialog" role="document">
		   		<div class="modal-content">
			      	<div class="modal-body" align="center">
				       	<p>La siguiente factura sera eliminada:</p>
				       	<h3 class="modal-title">{{ proveedor}} </h3>
				       	<h4 class="modal-title"># {{ codigo}} </h4>
						<div class="form-group" align="center">
							<button type="button"  @click="destroyinventario();actualisarregistrotabla(tablainventariotabla)" class="btn btn-danger">Eliminar</button> 
							<button type="button" @click="reset()" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
						</div>
			     	</div>
		    	</div>
		  	</div>
		</div>

		<div class="modal bg-dark" id="cargardatosnuevos" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdropn = "static" data-keyboard = "false"> 
		  <div class="modal-dialog modal-lg " role="document">
		    <div class="modal-content">
						<div class="factura-producto">
			     	<div  class="modal-body">
							<table class="table table-bordered">
									<thead class="table">
										<tr align="center">
											<th>
												<h4 class="modal-title">
													<div class="row" >
														<div class="col-6">
															<div class="custom-control custom-radio">
																<input 
																checked
																type="radio" 
																class="custom-control-input" 
																id="codigobuscar" 
																name="defaultExampleRadios"
																value="1"
																@click="opcionbus()">
																<label 
																	class="custom-control-label" 
																	for="codigobuscar">
																	Codigo
																</label>
															</div>
														</div>
														<div class="col-6">
															<div class="custom-control custom-radio">
																<input 
																type="radio" 
																class="custom-control-input" 
																id="nombrebuscar" 
																name="defaultExampleRadios"
																value="2"
																@click="opcionbus()">
																<label 
																	class="custom-control-label" 
																	for="nombrebuscar">
																	Nombre
																</label>
															</div>
														</div>
													</div>
												</h4>
											</th>
											<th><h4 class="modal-title">Proveedor</h4></th>
											<th><h4 class="modal-title">Codigo Factura</h4></th>
											<th><h4 class="modal-title">Total Factura</h4></th>
										</tr>
									</thead>
									<tbody >
									<tr align="center"> 	
										<td>
											<form @submit.prevent="buscarProdInventario()" class="form-group" autocomplete="off">
													<div class="input-wrapper">
														<input 
														type="text" 
														class="input" 
														placeholder="Buscar Producto"
														id="ProducFAC">
														<i class="input-icon fas fa-search"></i>
													</div>
												<button type="submit" style="display: none" class="btn btn-success">Guardar</button>
											</form>
											<h6 id="nfacturanull" style="color:red;display: none">
												El Producto Ingresada No Existe !!!
											</h6>
										</td>
										<td><h4 class="modal-title">{{ proveedor}}</h4></td>
										<td><h4 class="modal-title">{{ codigo}}</h4></td>
										<td><h4 class="modal-title">{{$separador(totarfactura)}}</h4></td>
									</tr>
									</tbody>
								</table>
							<table class="table table-bordered">
								<thead>
									<tr align="center" v-if="estado == 1">
										<td>
										<input 
										type="text" 
										class="form-control bg-dark text-white border-dark"
										id="codigop" 
										@change="buscarproducto()" 
										v-model="codigop" 
										autofocus>
										</td>
										<td>
											<input 
											readonly
											class="form-control bg-dark text-white border-dark"
											type="text"
											id="nombre_producto" 
											v-model= "nombre_producto">
										</td>
										<td>
											<input 
											readonly
											type="hidden"
											id="precio_ini"
											v-model="precio_ini">
											<div class="form-control bg-dark text-white border-dark"
											type="text" 
											id="precio_ini">
											{{ $separador(precio_ini) }}
											</div>
											
										</td>
										<td>
											<input 
											readonly
											class="form-control bg-dark text-white border-dark"
											type="text" 
											id="porcentaje"
											v-model="porcentaje">
										</td>
										<td>
											<input 
											readonly
											type="hidden" 
											id="precio_final"
											v-model="precio_final">
											<div class="form-control bg-dark text-white border-dark"
											type="text" 
											id="precio_ini">
											{{ $separador(precio_final) }}
											</div>
										</td>
										<td>
											<input 
											class="form-control bg-dark text-white border-dark"
											type="text" 
											id="cantidades"
											v-model="cantidades">
										</td>
										<td>
											<div class="form-control bg-dark text-white border-dark">
											{{ $separador(precio_ini*cantidades) }}
											</div>
										</td>
										<td>
											<input 
											class="form-control bg-dark text-white border-dark"
											type="text" 
											id="promocionfac"
											v-model="promocionfac">
										</td>
										<td>
											<button 
											type="submit" 
											v-on:keydown.tab="guardarinve()" 
											class="btn btn-success">Cargar</button>
										</td>
									</tr>
								</thead>
								<thead class="table-dark">
									<tr align="center">
										<th scope="col">Codigo</th>
										<th scope="col">Nombre</th>
										<th scope="col">Pre ini</th>
										<th scope="col">%</th>
										<th scope="col">Venta</th>
										<th scope="col">Cantidades</th>
										<th scope="col">Total</th>
										<th scope="col">Promo</th>
										<th v-if="estado == 1" colspan="5">Operaciones</th> 
									</tr>
								</thead>
								<tbody>
									<tr v-for="tablafact in tablainventariotabla" :key="tablafact.id"> 	
										<input 
											type="hidden" 
											id="codigo_producto"  
											v-bind:value="tablafact.codigo_factura">
										<td align="center">
											<input 
											type="hidden" 
											id="codigo_producto"  
											v-bind:value="tablafact.codigo_producto">
											{{ tablafact.codigo_producto}}
										</td>
										<td align="center"> 
											{{ tablafact.nombre_producto}}
										</td>
										<td align="center">
											{{ $separador(tablafact.precio_ini)}}
										</td>
										<td align="center">
											{{ tablafact.porcentaje}}
										</td>
										<td align="center">
											{{ $separador(tablafact.precio_ini * ((tablafact.porcentaje/100)+1)) }}
										</td>
										<td align="center">
											<button v-if="estado == 1"
												id="restacantidad2" 
												type="button"  
												@click="restarcantidades(tablafact)" 
												class="restacantidad2 btn btn-danger btn-sm"> 
													-
												</button>
											<input 
											type="hidden" 
											id="cantidades_inventario"  
											v-bind:value="tablafact.cantidades">
											{{ tablafact.cantidades }}
											<button v-if="estado == 1"
												type="button" 
												@click="sumarcantidades(tablafact)"
												class="sumarcantidad2 btn btn-primary btn-sm">
													+
												</button>
										</td>
										<td align="center">
											{{$separador(tablafact.cantidades*tablafact.precio_ini)}}
										</td>
										<td align="center">
											<button v-if="estado == 1"
												type="button"  
												@click="restarpromociones(tablafact)" 
												class="btn btn-danger btn-sm"> 
													-
											</button>
											<input 
											type="hidden" 
											id="cantidades_promocion"  
											v-bind:value="tablafact.promocion">

											{{ tablafact.promocion }}

											<button v-if="estado == 1"
											type="button" 
											@click="sumarpromociones(tablafact)"
											class="btn btn-primary btn-sm">
												+
											</button>
										</td>
										<td align="center" v-if="estado == 1"> 
											<div class="row" >
												<div class="col-12">
													<button 
														type="button" 
														@click="updateproductoinventarios(tablafact)"
														class="btn btn-primary btn-sm" 
														data-toggle="modal" 
														data-backdrop="static" 
														data-target="#updateproductoinventario">
														<i class="fas fa-edit"></i> 
													</button> 
													<button 
														type="button" 
														@click="deleteproductoinventarios(tablafact)" 
														class="btn btn-danger btn-sm" 
														data-toggle="modal" 
														data-backdrop="static" 
														data-target="#deleteproductoinventario">
														<i class="fas fa-trash-alt"></i>
													</button> 
												</div>
											</div>
										</td>
									</tr>
								</tbody>
							</table> 
							<table class="table">
								<thead class="table-dark">
									<tr align="center">
										<th scope="col">Items productos: {{ itemsproductos }}</th>
										<th scope="col">Total productos: {{ totarproductos }}</th>
										<th scope="col">Total Factura: {{ $separador(totarfactura) }}</th>
									</tr>
								</thead> 
							</table>
			      </div>
		      	</div>
		      	<div class=" text-center">
		      		<div class="row">
								<div  class="col-6" >
									<div id="paginationprofac">
										<pagination
										align = "center"
										:data="paginacion" 
										@pagination-change-page="getResults"
										:limit = "2"
										>
										</pagination>
									</div>
								</div>
								<div v-if="estado == 1" class="col-6">
									<div v-if="tablainventariotabla != 0">
										<button 
										type="button"  
										@click="procesarfact()"
										class="btn btn-success" 
										data-toggle="modal" 
										data-backdrop="static" 
										data-target="#finalisarfactura">
										Procesar factura
										</button>
										<button 
											type="button" 
											@click="cargarfunciones(tablainventariotabla),actualisarprocesoven(0,codigo)" 
											class="btn btn-secondary" 
											data-dismiss="modal">
											Poner en espera
										</button> 
									</div>
									<div v-else>
										<button 
											type="button" 
											@click="cargarfunciones(tablainventariotabla),actualisarprocesoven(0,codigo)" 
											class="btn btn-danger" 
											data-dismiss="modal">
											salir
										</button>
								</div>
								</div>
								<div v-else class="col-6">
										<button type="button" class="btn btn-primary" data-dismiss="modal">Editar</button>
										<button type="button" class="btn btn-danger" data-dismiss="modal">salir</button>
								</div>
					 		</div>	  
		      	</div>
		    </div>
		  </div>
			<div id="cantidadd" style="display: none;position:relative;top: -10rem;">
				<div class="row g-0" >
					<div class="col-3 col-md-3">
						<div  class="alert alert-danger" role="alert">
							Solo se permiten numeros
						</div>
					</div>
				</div>
			</div>
		</div> 
		<div class="modal bg-dark" id="deleteproductoinventario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  	<div class="modal-dialog" role="document">
		   		<div class="modal-content">
			      	<div class="modal-body" align="center">
				    	<h3>El siquiente producto sera eliminado</h3>
				       	<h3 class="modal-title">Codigo:{{ codigo_producto}} </h3>
				       	<h3 class="modal-title">Producto:{{ nombre_producto}} </h3>
				       	<h3 class="modal-title">Producto:{{ id}} </h3>	
						<div class="form-group" align="center">
							<button type="button"  @click="destroyProductoinventario()" class="btn btn-danger">Eliminar</button> 
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
						</div>
			     	</div>
		    	</div>
		  	</div>
		</div>
		<div class="modal bg-dark" id="finalisarfactura" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  	<div class="modal-dialog" role="document">
		   		<div class="modal-content">
						<div class="modal-body" align="center">
							<h3>La Siquiente Factura Sera Finalisada</h3>
							<h3 class="modal-title">Codigo:  {{codigo}} </h3>
							<h3 class="modal-title">proveedor:  {{proveedor}} </h3>
							<h3 class="modal-title">total:  {{$separador(totarfactura)}} </h3><br>	
							<div class="form-group" align="center">
								<button 
									type="submit" 
									@click="actualisarregistrotabla(tablainventariotabla),capturartablaproducto(tablainventariotabla),actualisarprocesoven(0,codigo)" class="btn btn-danger">
									Finalizar
								</button>
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
							</div>
						</div>
		    	</div>
		  	</div>
		</div>
		<div class="modal bg-dark" id="updateproductoinventario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  	<div class="modal-dialog" role="document">
		   		<div class="modal-content"><br>
		   			<h5 class="modal-title text-center" id="exampleModalLabel">El Siquiente producto Sera Editado</h5>
			      	<div class="modal-body" align="center">
			      		<form  @submit.prevent="actualisarprodufactu"   class="form-group" id="formeditarProductos" enctype = "multipart / form-data" autocomplete="off">  
					       	<div class="form-group"> 
								<div class="input-group input-group-lg">
									<div class="input-group-prepend">
										<div for="nombre_producto" class="input-group-text">Nombre Producto</div>
									</div>
									<input required="required" type="text" class="form-control" id="nombre_producto" aria-describedby="nombreHelp" placeholder="Codigo Factura" v-model="nombre_producto">
								</div>
							</div>
							<div class="form-group"> 
								<div class="input-group input-group-lg">
									<div class="input-group-prepend">
										<div for="precio_ini" class="input-group-text">Precio Factura</div>
									</div>
									<input required="required" type="text" class="form-control" id="precio_ini" aria-describedby="nombreHelp" v-on:keyup="procesovalo()" v-model="precio_ini">
								</div>
							</div>
							<div class="form-group"> 
								<div class="input-group input-group-lg">
									<div class="input-group-prepend">
										<div for="porcentaje" class="input-group-text">Porcentaje</div>
									</div>
									<input required="required" type="text" class="form-control" id="porcentaje" aria-describedby="nombreHelp" v-on:keyup="procesovalo()" v-model="porcentaje">
								</div>
							</div>
							<div class="form-group"> 
								<div class="input-group input-group-lg">
									<div class="input-group-prepend">
										<div for="precio_final" class="input-group-text">Precio Final</div>
									</div>
									<input  type="text" class="form-control" id="precio_final" aria-describedby="nombreHelp" v-on:keyup="preciofinall(),preciofinal()"  v-model="precio_final">
								</div>
							</div>
							<div id="cantidaddevol" style="display: none">
								<div class="row g-0" >
									<div class="col-6 col-md-12">
										<div  class="alert alert-danger" role="alert">
											La cantidad ingresada tiene que ser mallor al precio factura !!
										</div>
									</div>
								</div>
							</div>
							<div class="form-group" align="center">
								<button id="procesardevolu"  type="submit" class="btn btn-success">Editar</button> 
								<button type="button" class="btn btn-secondary" data-dismiss="modal" @click="limpiarinvenario()">Cancelar</button>
							</div>
						</form>
			     	</div>
		    	</div>
		  	</div>
		</div>
		<button 
		type="button" 
		hidden="hidden" 
		id="botoncargarmodal" 
		class="btn btn-success btn-sm" 
		data-toggle="modal" 
		data-backdrop="static" 
		data-target="#nuevoproducto">
		Producto
		</button>
		<div 
			v-if="modalproductos==true"  
			class="row"
		>
			<modalproducto-component
				:codigop="codigop" >
			</modalproducto-component>
		</div>
	</div>
</template>

<script>
	import EventBus from '../../event-bus';
export default 
	{
		data(){
			return{
				"_token": "{{ csrf_token() }}",
				ocultar: false,
				codigo:'',
				id:'',
				idmodal:'',
				nombre:'',
				codigop:'',
				nombre_producto:'',
				//promocion: '',
				precio_ini: '',
				porcentaje: '',
				precio_final: '',
				cantidades:'',
				promocionfac:'',
				proveedor: null,
				modalproductos: false,
				total_factura:'',
				pago:'',
				contar:'',
				fecha_pago:'',
				fecha_ingreso:'',
				modopago : 1,
				totalfactura:'',
				cargar:0,
				/*datos modal inventario productos*/
				codigo_producto: '', 
				cantidades_inventario:'',
				cantidades_promocion:'',
				codigo_factura: '',
				estado:'',
				/*fin*/
				totarfactura:'',
				totarproductos:'',
				itemsproductos:'',
				paginacion: {},
				tablainventariotabla :{},
				tablafactura :[],
				vacio:0,
				codprove:{}

			}
		},
		created(){
        	//Evento al volver al modulo de factura desde el modal de producto 
			EventBus.$on('volver-factura', data => {
				let me = this;
				this.modalproductos = data[0];
				//Al cancelar ventana modal tercero muestra de nuevo la lista
				//de coincidencias de terceros.
				if (data[1] == 0) {
					setTimeout(function(){  $('#codigop').focus();}, 1);
					me.limpiarinvenario();
				}
				//Al guardar en ventana modal tercero muestra en una lista el 
				//proveedor agregado.
				else {
					setTimeout(function(){ me.buscarproducto(); $('#cantidades').focus(); }, 1);
				}			
			});
		},
		mounted() 
		{
			EventBus.$on('proveedor-cargarfactura', data => {
	 			this.codprove = data;
				this.codigo ="";
				setTimeout(function(){ $('#codigoo').focus(); }, 1);
			});
			EventBus.$on('inventario-delete', data => {
	 			this.id = data.id;
	 			this.codigo = data.codigo;
	 			this.proveedor = data.proveedor.nombre;
			});
			EventBus.$on('producto-cargarinventario', data => 
			{ 
				setTimeout(function(){ $('#codigop').focus(); }, 1);
				if (data.inventarioproducto.length == 1 ) {
					this.totalfactura = data.inventarioproducto[0].total;
				}
				else{
					this.totalfactura = 0;
				}
				this.codigo = data.codigo;
				this.pago = data.pago;
				this.fecha_pago = data.fecha_pago;
				this.proveedor = data.proveedor.nombre;
				this.id = data.id;
				this.estado = data.estado;
				this.getResults();
				if (this.estado == 0) {
					this.procesofact = 0;
				}
				else{
				this.procesofact = 1;
				}
				this.actualisarprocesoven(this.procesofact,this.codigo)
			});
      //carga tabla una ves se ingrese un producto en la factura
			EventBus.$on('inventario-cargarproducto', data => 
            {
				this.getResults();
			});
			EventBus.$on('modaltabla-actualisar',data =>{
				this.totarfactura = data.totalpro;
				var quitar = this.tablainventariotabla.findIndex(dato => dato.id === data.inventarioproducto.id);	 
				this.tablainventariotabla.splice(quitar,1,data.inventarioproducto);
			});
    },
		beforeDestroy(){
			EventBus.$off('volver-factura');
		},
		methods: 
		{
			actualisarprocesoven(data,data2){
				let metodo = this;  
					axios.post('http://venta.test/actualisarprocesoven',{
						params:{data,data2}
					})
			},
			soloNumeros()
			{
				var inputcantidades = $('#cantidades').val();
				var inputpromo = $('#promocionfac').val();
				if (isNaN(inputcantidades) == true) 
				{
					$("#cantidadd").css("display", "block").fadeIn().delay(4000).fadeOut();
					setTimeout(function(){ $('#cantidades').focus(); }, 1);
				}
				if (isNaN(inputpromo) == true) 
				{
					$("#cantidadd").css("display", "block").fadeIn().delay(4000).fadeOut();
					setTimeout(function(){ $('#promocionfac').focus(); }, 1);
				}
			},
			preciofinall(){
				var precio_final = $('#precio_final').val();  
				var precioinicol = Number(this.precio_ini);
				if(precio_final == '')
				{ 
					document.getElementById("cantidaddevol").style.display = "block"; 
				}
				else
				{
					if (precio_final > precioinicol) 
					{
						document.getElementById("cantidaddevol").style.display = "none";
					}
					else
					{
						document.getElementById("cantidaddevol").style.display = "block";
					}
				}
			},
			deleteproductoinventarios(data)
			{
				this.id = data.id;
	 			this.codigo_producto = data.codigo_producto;
	 			this.nombre_producto = data.nombre_producto;
			},
			cargarfunciones(data)
			{
				let metodo = this;
				metodo.actualisarregistrotabla(data);
				setTimeout(metodo.cargartablafactura, 900);
			},
			restarpromociones(data)
			{
				if (data.promocion <= 0) {
				}
				else 
				{
					var cantidades_promocion = this.cantidades_promocion = data.promocion--;
				}  
			},
			sumarpromociones(data)
			{
				var cantidades_promocion = this.cantidades_promocion = data.promocion++; 
			},
			restarcantidades(data)
			{
				let metodo = this;
				if (data.cantidades <= 0) {
					metodo.destroyProductoinventario2(data.id); 
				}
				else 
				{
					var cantidadesmas = this.cantidades_inventario = data.cantidades--; 
					this.codigo_producto = this.codigo_producto = data.codigo_producto;  
					var cantidades_inventario = data.precio_ini 
					this.totarproductos = this.totarproductos - 1;
					this.totarfactura = this.totarfactura - cantidades_inventario;  
				}  
			},
			sumarcantidades(data)
			{ 
				var cantidadesmas = this.cantidades_inventario = data.cantidades++; 
				this.cantidades_inventario = data.precio_ini;
				this.totarproductos = this.totarproductos + 1;
				this.totarfactura = parseInt(this.totarfactura) + parseInt(this.cantidades_inventario);
			},
			updateproductoinventarios(data)
			{0
				this.cantidades_inventario = data.cantidades
				this.cantidades_promocion = data.promocion
				this.codigo_factura = data.codigo_factura;
				this.idmodal = data.id;
				this.codigo_producto = data.codigo_producto;
				this.nombre_producto = data.nombre_producto; 
				this.precio_ini = data.precio_ini;
				this.porcentaje = data.porcentaje;
				this.precio_final = parseInt(this.precio_ini)*((parseInt(this.porcentaje)/100)+1);
			},
			procesarfact(data)
			{
				this.codigo ;
	 			this.proveedor;
	 			this.totarfactura; 
			},
			capturartablaproducto(data){
			 axios.post('http://venta.test/capturartablaproducto',{
			 	params:{data}
			 })
			 .then(function(res){ 
			 	EventBus.$emit('inventario-agregar',res.entradafactura)
		 		$('#finalisarfactura').modal('hide');
		 		$('#cargardatosnuevos').modal('hide'); 
    			$(document.body).removeClass('modal-open');
				$('.modal-backdrop').remove();
					
				})
			},
			actualisarregistrotabla(data){
				let metodo = this; 
				var codigofact = metodo.codigo 
				if (data.length !== 0){ 
					axios.post('http://venta.test/actualisarregistrotabla',{
						params:{data}
					})
 				}
			},
			getResults(page = 1) 
			{
				axios
					.get('http://venta.test/inventarioproducto?page=' +page,{ params:{  codigo: this.codigo, } })
					.then(response => {  
						this.tablainventariotabla = response.data.tablainventariotabla.data;
						this.totarfactura = response.data.totarfactura;
						this.totarproductos = response.data.totarproductos;
						this.itemsproductos = response.data.itemsproductos;
						this.paginacion = response.data.tablainventariotabla; 
					});
			},
			guardarinventario : function()
			{ 
				let metodo = this;
				axios.post('http://venta.test/entradafactura',{
					codigo: this.codigo,
					total_factura: this.total_factura ,
					proveedor: this.proveedor,
					fecha_pago:this.fecha_pago,
					fecha_ingreso:this.fecha_ingreso,
					pago:this.pago

				})
				.then(function(res){ 
					$('#crearinventario').modal('hide');
	    			$(document.body).removeClass('modal-open');
					$('.modal-backdrop').remove();
					EventBus.$emit('inventario-agregar', res.data.entradafactura)
					metodo.reset();
				})
				.catch(function(err){
					console.log(err)
				});
			},
			destroyinventario: function()
			{
				let metodo = this;
				axios.delete('http://venta.test/entradafactura/'+this.codigo)
				.then(function(response){
					EventBus.$emit('inventario-agregar',response.data)
					metodo.reset();
				}).catch(function(error){
					console.log(error)
				});
			},
			destroyProductoinventario: function(){
				axios.delete('http://venta.test/inventarioproducto/'+this.id). 
				then(function(response){
					EventBus.$emit('inventario-cargarproducto',response.data);
					$('#deleteproductoinventario').modal('hide'); 
				}).catch(function(error){
					console.log(error)
				});
			},   
			destroyProductoinventario2: function(data){
				this.id = data;
				axios.delete('http://venta.test/inventarioproducto/'+this.id). 
				then(function(response){
					EventBus.$emit('inventario-cargarproducto',response.data);
					$('#deleteproductoinventario').modal('hide'); 
				}).catch(function(error){
					console.log(error)
				});
			}, 
			pagos: function(modopago)
			{
				var fecha = new Date()
				if(modopago=='1')
				{   
					document.getElementById('boton_guardar').disabled = false; 
					this.modopago = 0;
					this.pago = 'Acredito'; 
					this.fecha_ingreso = fecha.getDate()+"-"+(fecha.getMonth() +1)+"-"+fecha.getFullYear();
				}
				else
				{
					document.getElementById('boton_guardar').disabled = false;
					this.modopago = 1;
					this.pago = 'Efectivo';
					this.fecha_pago = fecha.getDate()+"-"+(fecha.getMonth() +1)+"-"+fecha.getFullYear();
					this.fecha_ingreso = fecha.getDate()+"-"+(fecha.getMonth() +1)+"-"+fecha.getFullYear(); 
				}
			},
			buscarproducto: function()
			{
				let metodo = this;
				let codigo = $('#codigop').val()

				axios.get('http://venta.test/productos/'+codigo)
				.then(function(response)
				{ 
					var contar = response.data.contar;
					//si el producto no existe abre la modal para crear el producto 
					if (contar == 0) 
					{
						metodo.modalproductos = true;
					//boton que mustra modal de crear producto si el producto no existe 
					setTimeout(function(){ $('#botoncargarmodal').click();  }, 1);
						metodo.nombre_producto = "";
						metodo.precio_ini = "";
						metodo.porcentaje = "";
						metodo.precio_final = "";
					}
					else
					{
						if (codigo == '') {
        			return setTimeout(function(){ $('#codigop').focus(); }, 1);
        		}
						$('#nombre_producto').val(response.data.tablaprod[0].nombre);
						metodo.nombre_producto = response.data.tablaprod[0].nombre;
						metodo.precio_ini = response.data.tablaprod[0].precio_ini;
						metodo.porcentaje = response.data.tablaprod[0].porcentaje;
						metodo.precio_final = response.data.tablaprod[0].precio_final;
        		$("#nombre_producto").prop('disabled', true);
        		$("#precio_ini").prop('disabled', true);
        		$("#porcentaje").prop('disabled', true);
        		$("#precio_final").prop('disabled', true);
						setTimeout(function(){ $('#cantidades').focus(); }, 1);
					}
				})
				.catch(function(error){
					console.log(error)
				});
			},
				//ingresar inventario 
			guardarinve: function()
			{
				let metodo = this;
				var inputcantidades = $('#cantidades').val();
				var inputpromo = $('#promocionfac').val();
				
				//Verifica si codigop no viene vacía.
				if ($('#codigop').val() == '') 
				{
					metodo.limpiarinvenario();
					setTimeout(function(){ $('#codigop').focus(); }, 1);
				}
				else{
					//Verifica si cantidades no viene vacío.
					if ($('#promocionfac').val() == '') 
					{		
						if ($('#cantidades').val() <= 0) 
						{
							setTimeout(function(){ $('#cantidades').focus(); }, 1);
						}
						else
						{		
							if (isNaN(inputcantidades) == true) 
							{	
								$("#cantidadd").css("display", "block").fadeIn().delay(4000).fadeOut();
								setTimeout(function(){ $('#cantidades').focus(); }, 1);
							}
							else
							{		
								this.cargar = 1;
							}
						}
					}
					else{		
						if (isNaN(inputpromo) == true || isNaN(inputcantidades) == true) 
						{	
							$("#cantidadd").css("display", "block").fadeIn().delay(4000).fadeOut();
							setTimeout(function(){ $('#promocionfac').focus(); }, 1);
						}
						else
						{		
							this.cargar = 1;
						}
					}
				}
				if(this.cargar == 1)
				{
					axios.post('http://venta.test/inventarioproducto',{
						codigo_producto: this.codigop,
						codigo_factura: this.codigo,
						nombre_producto: this.nombre_producto,
						precio_ini: this.precio_ini,
						porcentaje: this.porcentaje,
						precio_final: this.precio_final,
						cantidades: this.cantidades,
						promocionfac: this.promocionfac,
					})
					.then(function(res){ 
						metodo.limpiarinvenario();
						EventBus.$emit('inventario-cargarproducto',res.data)
						$('#codigop').focus()
					})
				}
			},
			actualisarprodufactu: function()
			{ 
				let metodo = this; 
				var data = new  FormData(); 
				//Añadimos la imagen seleccionada  
				data.append('codigo_factura', this.codigo_factura);
				data.append('codigo_producto', this.codigo_producto);
				data.append('nombre_producto', this.nombre_producto);
				data.append('precio_ini', this.precio_ini);
				data.append('porcentaje', this.porcentaje); 
				data.append('cantidades_inventario', this.cantidades_inventario); 
				data.append('cantidades_promocion',this.cantidades_promocion); 
				data.append('idmodal', this.idmodal); 
				//Añadimos el método PUT dentro del formData
				// Como lo hacíamos desde un formulario simple _(no ajax)_
					data.append('_method', 'PUT');
				//Enviamos la petición
				axios.post(`http://venta.test/inventarioproducto/${this.idmodal}`,data)
				.then(function(res)
				{ 
					EventBus.$emit('modaltabla-actualisar',res.data)
					$('#updateproductoinventario').modal('hide');
					$(document.body).removeClass('modal-open');
					$('.modal-backdrop').remove();
					metodo.limpiarinvenario();
				})
				.catch(function(err){
					console.log(err)
				});
			},
			reset: function()
			{
				this.total_factura = "";
				this.nombre = "" ;
				this.codigo = "" ;
				this.pago = "" ;
				this.proveedor = "" ;
				this.modopago = 1 ;
				this.codigop = "" ;
				this.nombre_producto = "" ;
				this.cantidades = "" ;
				this.precio_ini = "" ;
				this.porcentaje = "" ;
				this.precio_final = "" ;
				document.getElementById('boton_guardar').disabled = true;
				$('#deleteinventario').modal('hide');
				$(document.body).removeClass('modal-open');
				$('.modal-backdrop').remove();
			},
				//limpiar modal de inventario
			limpiarinvenario: function()
			{
				this.codigop = "";
				this.nombre_producto = "";
				this.cantidades = "";
				this.precio_ini = "";
				this.porcentaje = "";
				this.precio_final = "";
				this.promocionfac = "";
				this.cargar = 0;
				setTimeout(function(){ $('#codigop').focus(); }, 1);
				document.getElementById("cantidaddevol").style.display = "none";
			},
			preciofinal:function()
			{
				var incremento = parseInt(this.precio_final)-parseInt(this.precio_ini);
				var dividir = incremento/parseInt(this.precio_ini);
				var convertir = dividir*100;
				this.porcentaje = convertir;
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
			editarproductoinventario(data){
				EventBus.$emit('editar-producto-inventario',data)			
			},
			cargartablafactura(){
				var dato2 = this.codigo;
				axios.post('http://venta.test/mostartotalinventio',{ 
				dato2:dato2
				})
				.then(function(res)
				{ 
					EventBus.$emit('inventario-actualisartabla', [res.data, dato2])
				})
				.catch(function(err){
					console.log(err)
				});
			},
			buscarProdInventario: function()
			{ 
				let metodo = this; 
				var codigo_factura = this.codigo;
				var ProducFAC = $('#ProducFAC').val()
				if (ProducFAC !== "") {
					metodo.vacio = 0
					if (document.getElementById('codigobuscar').checked) {
						var codigo = 1;
					} else {
						var codigo = 2;
					}
					axios.post('http://venta.test/buscarProinventario',{ 
						ProducFAC:ProducFAC,
						codigo:codigo,
						codigo_factura:codigo_factura
					}).then(function(res)
					{  
						if (res.data.buscarnfactura.length >= 1) {
							metodo.tablainventariotabla = res.data.buscarnfactura;
							$("#nfacturanull").css("display", "none");
							$("#paginationprofac").css("display", "none");
						}
						else{
							$("#nfacturanull").css("display", "block");
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
							$("#paginationprofac").css("display", "block");
					}		
				}
			},
			opcionbus: function()
			{
				$('#ProducFAC').focus();
			},
		}
	}
</script>
<style>
  .formulario .radio label
  {
  	left: 40px;
  	top: 8px;
    display: inline-block;
    cursor: pointer;
    color: #FF4136;
    position: relative;
    padding: 5px 15px 5px 51px;
    font-size: 1em;
    border-radius: 5px;
    -webkit-transition: all 0.3s ease;
    -o-transition: all 0.3s ease;
    transition: all 0.3s ease; 
  }
  .formulario .radio label:hover  
  {
    background: rgba(255, 65, 54, 0.1); 
  }
  .formulario .radio label:before  
  {
    content: "";
    display: inline-block;
    width: 17px;
    height: 17px;
    position: absolute;
    left: 15px;
    border-radius: 50%;
    background: none;
    border: 3px solid #FF4136; 
  }
  .formulario input[type="radio"] 
  {
    display: none; 
  }
  .formulario input[type="radio"]:checked + label:before 
  {
    display: none; 
  }
  .formulario input[type="radio"]:checked + label 
  {
    padding: 5px 15px;
    background: #FF4136;
    border-radius: 2px;
    color: #fff; 
  } 
 .factura-producto .table > thead > tr > th, 
 .factura-producto .table > tbody > tr > th, 
 .factura-producto .table > tfoot > tr > th, 
 .factura-producto .table > thead > tr > td, 
 .factura-producto .table > tbody > tr > td, 
 .factura-producto .table > tfoot > tr > td {
    padding: 2px !important;  
  } 
	.input-wrapper {
  position: relative;
  width: 271px;
}
.input {
  padding: 5px 5px 5px 35px;
  width: 100%;
}
.input-icon {
  position: absolute;
  width: 20px;
  height: 20px;
  left: 12px;
  top: 50%;
  transform: translateY(-50%);
}

</style>