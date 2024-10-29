<template> 
	<div>
		<div class="row">
			<div class="col-9">
				<div class="row">
					<div class="col-8">
						<div class="row">
							<div class="col-auto"> 						
								<button 
									type="button" 
									@click="guardarrproducto(ventaespera);ponerespera(esperaventa)"
									class="btn btn-primary">
									Espera
								</button> 
								<div class="d-inline p-1" v-for="(esperav,index) in esperaventa" :key="esperav.id">
									<button
										v-bind:id ="esperav.nespera"
										type="button" 
										class="botonspera btn btn-primary"
										@click="guardarrproducto(ventaespera);mostarespera(esperav)"
										v-bind:value="esperav.nespera"
										>
										{{ index+1}} 
                    <br>
                    <div class="totalesp" v-bind:id ="esperav.nespera+'totalespera'">
                    {{ $separador(esperav.total) }} 
                    </div>
                    <div class="cargando" v-bind:id ="esperav.nespera+'totalesperacargar'" style="display: none">
                     Cargando..
                    </div>
									</button>
								</div>
							</div>
						</div><br>
						<div class="row">
							<div class="col-12"> 
								<div id="codproducto" style="display: none" class="alert alert-danger" role="alert">
									El codigo ingresado No Existe !!!
								</div> 
							</div> 
						</div>
					</div> 
					<div class="col-4">
						<table class="table">
							<thead>
									<tr align="center">
										<th scope="col"><h4>Total</h4></th>
										<th scope="col"><h4>Cant</h4></th>
										<th scope="col">
											<button
											id="procesarv" 
											disabled 
											type="button" 
											class="procesarventas btn btn-success" 
											@click="guardarrproducto(ventaespera);cargarmodalventas()">
											<i class="fas fa-sign-in-alt"></i>
										</button>
									</th>
									</tr>
							</thead> 
							<tbody> 
								<tr> 
									<td align="center"><h4>{{$separador(totalfactura_venta)}}</h4></td>  
									<td align="center"><h4>{{totalproducto_venta}}</h4></td>
									<td align="center">
										<button 
											id="procesarv" 
											type="button" 
											class="procesarventas btn btn-danger"
											@click="verificarresetventa()">
											<i class="fas fa-window-close"></i>
										</button> 	
									</td>
								</tr> 
							</tbody>
						</table>
					</div>
				</div>
				<div style="height: 340px; overflow: auto;">
					<table id="mytable" class="table  table-hover table-bordered table-sm">
						<thead style="position: sticky; top: 0; z-index: 1; background-color: #eee;">
							<tr align="center">
								<th scope="col">Codigo</th>
								<th scope="col">Producto</th>
								<th scope="col">precio</th>
								<th scope="col">cantidad</th>
								<th scope="col">Total</th>
								<th scope="col">Operaciones</th>
							</tr>
						</thead>
						<tbody >
							<tr  v-for="(ventaesp, index) in ventaespera" :key="ventaesp.id" v-bind:id ="ventaesp.id"> 
								<td align="center">
								<input 
								type="hidden" 
								id="id"  
								v-bind:value="ventaesp.id">
								<input 
								type="hidden" 
								id="codigo_productos"  
								v-bind:value="ventaesp.codigo">
								<h3>
								{{ ventaesp.codigo }}
								</h3>  	
								</td>
								<td align="center">
									<h3>
									{{ ventaesp.nombre}}
									</h3>
								</td>    
								<td align="center">
									<input 
									type="hidden" 
									id="precio_ventas"  								
									v-bind:value="ventaesp.precio">
									<h3>
									{{ $separador(ventaesp.precio) }}
									</h3>
								</td> 
								<td align="center">
									<input 
									type="hidden" 
									id="cantidades_ventas" 
									v-bind:value="ventaesp.cantidades">
									<h3>
									{{ ventaesp.cantidades}}
									</h3>
								</td>
								<td align="center"> 
									<h3>
									{{ $separador(ventaesp.precio*ventaesp.cantidades)}}
									</h3>
									
								</td>
								<td align="center">  
									<button 
									id="boton-restar" 
									type="button" 
									@click="restarcantidades(ventaesp, index)"
									v-bind:value="ventaesp.id" 
									class="restarcantidad1 btn btn-danger btn-sm">
									-
									</button>
									<button 
									id="boton-sumar"
									type="button" 
									@click="sumarcantidades(ventaesp)"
									class="sumarcantidad2 btn btn-primary btn-sm">
									+
									</button>
								</td>   
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-3">
        <div class="row">
          <div class="col-12" style="text-align: center;">
						<div class="row" >
							<div class="col-auto">
								<table class="table">
									<thead>
											<tr align="center">
												<th scope="col">
													<div class="custom-control custom-radio">
														<input 
														checked
														type="radio" 
														id="gridRadios1"
														value="option1"
														class="custom-control-input" 
														name="defaultExampleRadios"
														@click="pagos('0')">
														<label 
															class="custom-control-label" 
															for="gridRadios1">
															Codigo
														</label>
													</div>
												</th>
												<th scope="col">
													<div class="col-auto">
														<div class="custom-control custom-radio">
															<input
															type="radio"  
															id="gridRadios2"
															value="option2"
															class="custom-control-input" 
															name="defaultExampleRadios"
															@click="pagos('1')">
															<label 
																class="custom-control-label" 
																for="gridRadios2">
																Nombre
															</label>
														</div>
													</div>
												</th>
											</tr>
									</thead>
								</table>
							</div>
						</div>
						<div v-if="modopago == 0">
							<input 
							type="text" 
							class="form-control" 
							id="cproducto" 
							@change="guardarrproducto(ventaespera);ventaproducto()"  
							autofocus>
						</div>
						<div v-else>
							<input 
							type="text" 
							class="form-control" 
							id="buscarproductolista"
							v-on:keyup="buscarproductolista()">
						</div>
          </div>
					<div  class="col-12 tablalista" v-for="mostarproducto in mostarproductotabla" :key="mostarproducto.id"  @click="guardarrproducto(ventaespera);ventaproducto(mostarproducto)"> 
						<label >
									{{mostarproducto.nombre}}
						</label> 	 
					</div>
        </div>
				<!--
					<div class="row">
						<tr class="col-6 tablalista" v-for="mostarproducto in mostarproductotabla" :key="mostarproducto.id"> 
							<td id="" align="center">
								<a  @click="ventaproducto(mostarproducto)">
									<div class="row">
										<div class="col-12">
											<img :src="'imagenes/'+ mostarproducto.imagenprod" style="height:80px; width:90px;">  
										</div>
									</div> 
									<div class="row" >
										<div class="col-12">
											{{cortarnombre(mostarproducto.nombre)}}
										</div>
									</div> 
								</a> 	
							</td>  
						</tr>
          </div>
				-->
		  </div>
    </div>
		<modalventa-component></modalventa-component> 	
	</div>	
	
</template>
<script>
import EventBus from '../../event-bus';
	export default 
	{
		data(){
			return{
				esperaventa:[],
      	mostarproductotabla:[],
				ventaespera:[],
				codigo_productos:'',
				totalproducto_venta:'',
				totalfactura_venta:'',
				nombre_producto:'',
				nespera:'',
				id:'',
				cantidades_ventas:'',
				precio_ventas:'',
				cproducto:'',
				usuariocliente:'',
				codigoenuso:0,
				modopago : 0,
			}
		},
		
		//created cambia el data de la tabla al edit o insert 
	 	created()
    {
			 // lipiarcontedino es escuchado de la motal que procesa la factura modalventa.vue
			EventBus.$on('lipiarcontedino', data => {
				document.getElementById("procesarv").disabled = true;
				$(".botonspera").css("background-color", "#0275d8");
				$(".totalesp").css("display", "block");
				$(".cargando").css("display", "none");
	 			this.ventaespera = [];
				this.totalproducto_venta= '';
				this.totalfactura_venta = '';
				this.codigoenuso = 0;
				this.cantidades_ventas = 0;
        this.esperaventa = data.esperaventa;
				$('#cproducto').focus();
			});
		},
		//mounted cargar pagina por primera vez 
		mounted(){  
			axios
			.get('http://venta.test/venta')
			.then(response =>{
				this.esperaventa = response.data.esperaventa,
				this.mostarproductotabla = response.data.mostarproductotabla
				})
				
			window.addEventListener('keyup',this.modalcobroventa)
			window.addEventListener('keydown',this.comandoflechas)
		},
		destroyed () {
			window.removeEventListener('keyup',this.modalcobroventa)
			window.removeEventListener('keydown',this.comandoflechas)
		},
		beforeDestroy(){
			EventBus.$off('lipiarcontedino');
		},
		// methods cargar las funciones o metodos a utilizar
		methods: 
		{
			modalcobroventa (e) {
				if(e.keyCode===13 && e.ctrlKey){let metodo = this;
					if (metodo.totalfactura_venta >= 1) {
						EventBus.$emit('modalventas',[this.totalfactura_venta,this.codigoenuso]);
						$("#procesarventa").modal('show');
					}
				}
			},
			/*comando control + flechas  cambia de opcione en el buscador de los productos*/
			comandoflechas(e) {
				if (e.ctrlKey) 
				{
					if(e.keyCode===39 && e.ctrlKey)
					{
					console.log("hola a buscador");
					document.getElementById("gridRadios2").click();
					}
					if(e.keyCode===37 && e.ctrlKey)
					{
						document.getElementById("gridRadios1").click();
					}
				} 
				else 
				{
					if(e.keyCode===37){
					document.getElementById("boton-restar").click();
					}
					if(e.keyCode===39){
						console.log("hola a sumar");
						document.getElementById("boton-sumar").click();
					}
				}
				
			},
			mostarespera(data)
			{
				let metodo = this;
				var nespera = data['nespera']; 
				axios.post('http://venta.test/mostarespera',{
					nesperaen:nespera
				})
				.then(function(res){ 
					$('#cproducto').val('');
			 		$('#cproducto').focus(); 
					metodo.totalfactura_venta = res.data.totalfactura_venta; 
					metodo.totalproducto_venta = res.data.totalproducto_venta;
					metodo.ventaespera = res.data.ventaespera;  
					if (metodo.totalfactura_venta === null) 
					{
						document.getElementById("procesarv").disabled = true;
					}else{
						document.getElementById("procesarv").disabled = false;
					}
					var nespera = res.data.numeroespera 
					metodo.codigoenuso = nespera;  
					$(".botonspera").css("background-color", "#0275d8");
         	$(".totalesp").css("display", "block");
					$(".cargando").css("display", "none");
					setTimeout(function()
					{  
						$("#"+nespera).css("background-color", "red");
						$("#"+nespera+'totalespera').css("display", "none");
						$("#"+nespera+'totalesperacargar').css("display", "block");
					}, 120);
					
				})
				.catch(function(err){
					console.log(err)
				});
			},  
			restarcantidades(data, index)
			{ 
				$('#gridRadios1').click();   
				if (data.cantidades <= 0) {
				}
				else 
				{
					var cantidad = this.cantidades_ventas = data.cantidades--; 
					if (cantidad <= 1) { 
					let metodo = this;
					metodo.borrarproductoventa(data); 
					this.ventaespera.splice(index, 1);
					} 
					var total = this.totalfactura_venta = this.totalfactura_venta - data.precio;
					this.totalproducto_venta = this.totalproducto_venta - 1 ;
				} 
			},
			sumarcantidades(data)
			{
				this.modopago = 0;
				$('#gridRadios1').click(); 
				this.cantidades_ventas = data.cantidades++;
				this.precio_ventas = data.precio;
				this.totalfactura_venta = parseInt(this.totalfactura_venta) + parseInt(this.precio_ventas); 
				this.totalproducto_venta = this.totalproducto_venta + 1; 
			},
			cortarnombre(data)
			{
				var tamanotext = data.length;
				if (tamanotext > 5) 
				{
					data = data.slice(0,18);
				}
				return data;
			},
			ponerespera(datos)
			{
				document.getElementById("procesarv").disabled = true;
				$(".botonspera").css("background-color", "#0275d8");
      	$(".totalesp").css("display", "block");
				$(".cargando").css("display", "none");
				this.ventaespera = [];
				this.totalfactura_venta = "";
				this.totalproducto_venta = "";
				this.codigoenuso = 0;
				$('#cproducto').val('');
				$('#cproducto').focus();
				/*axios.get('http://venta.test/venta').then(response =>(this.esperaventa = response.data.esperaventa))*/
			},
			ventaproducto: function(data)
			{
				let metodo = this;
				if (data == undefined) {
				var codigo = $('#cproducto').val()
				}
				else{
				var codigo = data.codigo;
				}
				var codigoenuso = this.codigoenuso;  
				axios.post('http://venta.test/craerspera',{ 
				codigoenv:codigo,
				codigoenuso:codigoenuso,
				})
				.then(function(res)
				{ 
					if (res.data == 'nada') {
						$("#codproducto").css("display", "block").fadeIn().delay(4000).fadeOut();
						$('#cproducto').val('');
						$('#cproducto').focus();
					}
					else
					{
						$("#codproducto").css("display", "none");
						metodo.totalfactura_venta = res.data.totalfactura_venta;
						metodo.totalproducto_venta = res.data.totalproducto_venta;
						metodo.codigoenuso = res.data.codigo_atrabajar;  
						metodo.ventaespera = res.data.ventaespera;
						if (metodo.totalfactura_venta === null) 
						{
							document.getElementById("procesarv").disabled = true;
						}else{
							document.getElementById("procesarv").disabled = false;
						}
						$('#cproducto').val('');
						$('#cproducto').focus();
						$('#buscarproductolista').val('');
						$('#buscarproductolista').focus();
					}
				})
				.catch(function(error){
				console.log(error)
				});
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
					metodo.mostarproductotabla = res.data.listadoproduc;
				})
				.catch(function(error){
				console.log(error)
				});
			},
			cargarmodalventas()
			{
				EventBus.$emit('modalventas',[this.totalfactura_venta,this.codigoenuso]);
				$("#procesarventa").modal('show');
			},
			verificarresetventa(data)
			{ 
				if (this.codigoenuso > 0) {
					EventBus.$emit('verificarventamodal',[this.codigoenuso]);
				$("#verificarvent").modal('show');
				}
				
			},
			borrarproductoventa: function(data)
			{	 	  
				var idproductoventa = data.id
				var codigoproductoventa = data.codigo
				var nfactura = data.id_ventas
				var precio = data.precio
				let metodo = this;
				axios.delete('http://venta.test/venta/'+idproductoventa+'!!'+codigoproductoventa+'!!'+this.codigoenuso+'!!'+nfactura+'!!'+precio)
				.then(function(res){
				/*metodo.mostarespera(res.data);*/
				}).catch(function(error){
				console.log(error)
				});
			},
			guardarrproducto(data)
			{
				let metodo = this;
				if (data.length !== 0) 
				{ 
					axios.post('http://venta.test/cargarproductoventa',
					{
						params:{data}
					})
					.then(function(res){
            metodo.esperaventa = res.data.esperaventa; 
					})
				}
			}, 
			pagos: function(modopago)
			{
				if(modopago=='0')
				{   
					this.modopago = 0;
					$('#buscarproductolista').val('');
					setTimeout(function(){  $('#cproducto').focus();}, 1);
				}
				else
				{
					this.modopago = 1; 
					$('#cproducto').val('');
					setTimeout(function(){  $('#buscarproductolista').focus();}, 1);
				}
			},
		},
	}
	/*comando de teclado para abrir modal de cobro de venta*/

</script>
<style scoped>
a {
  transition: background-color .5s;
}
#productoslista {
display:flex;
align-items:center;
justify-content:center;
align-items:center;
padding: 15px;
border: rgb(43, 198, 218) 5px dashed;
border-top-left-radius: 20px;
border-bottom-right-radius: 20px;
}
.tablalista:hover{
background-color:rgb(93, 169, 246);
color: rgb(8, 8, 8);
}
 

img {
  float: left;
}
</style>
