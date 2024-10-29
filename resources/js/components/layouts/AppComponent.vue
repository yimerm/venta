<template>
	<div >
		<div v-if="vista == 1">
			<sidebar-component></sidebar-component>
			<div class="container-fluid">
				<router-view></router-view>
			</div>
		</div> 
		<div v-else>
			<div  class="contenido container-fluid h-100">
				<div class="d-flex justify-content-center">
					<div class="logo">
						<div class="d-flex justify-content-center">
							<div class="logo_container">
									<img src="imagenes/logo.jpg" class="brand_logo" alt="Logo">
							</div>
						</div>
						<div class="d-flex justify-content-center form_container">
							<form @submit.prevent="login"   class="form-group" id="formprocesarventa" enctype = "multipart / form-data" autocomplete="off">
								<div class="input-group mb-3">
									<div class="input-group-append">
										<span class="input-group-text"><i class="fas fa-user"></i></span>
									</div>
									<input type="text" name="" class="form-control input_user" id="usuario" placeholder="usuario" v-model="usuario">
								</div>
								<div class="input-group mb-2">
									<div class="input-group-append">
										<span class="input-group-text"><i class="fas fa-key"></i></span>
									</div>
									<input type="password" name="" class="form-control input_pass" id="contraseña" placeholder="password" v-model="contraseña">
								</div>
								<div class="d-flex justify-content-center mt-3 login_container"> 
							         <button type="submit" name="button" class="btn login_btn">Login</button>
						        </div>
							</form>
						</div>
					</div>
				</div>
				<div id="usuariofalso" style="display: none" class="alert alert-danger" role="alert">
					El Usuario y contraseña no existe !!
				</div>
			</div>
		</div>
	</div>
</template>
<script>
import EventBus from '../../event-bus';
	export default {
		data(){
			return{
				vista:0,
				usuario:'',
				contraseña:''
			}
		},
		created(){
			/*EventBus.$on('producto-agregar', data => { 
				axios.get('http://venta.test/proveedor').then(response =>(this.proveedore = response.data.proveedore))

			});*/
		},
		mounted(){
			/*axios.get('http://venta.test/proveedor').then(response =>(this.proveedore = response.data.proveedore))*/
		},

		methods: {
			login: function()
			{ 
				var usuario = this.usuario;
				var contraseña = this.contraseña;
				let metodo = this;
				axios.post('http://venta.test/login',{ 
				usuario:usuario,
				contraseña:contraseña
				})
				.then(function(res){
					if (res.data == "error") 
					{
						metodo.usuario = "";
						metodo.contraseña = "";
						$('#usuario').focus(); 
						$("#usuariofalso").css("display", "block");
						setTimeout(function() {
							$("#usuariofalso").css("display", "block").fadeOut(1500);;
						},2000); 
					}
					else
					{ 
						metodo.vista = 1; 				
						//se declara el ususrio logueado 
						Vue.prototype.usuariologiado=res.data.users;
						//una inicie sesion carga la ruta tablero 
						if (metodo.$route.path !== '/tablero') {
							metodo.$router.push('tablero');
						} 
					} 	
				})
				.catch(function(error){
				console.log(error)
				});        		
			},
			editproveedor(data){
			EventBus.$emit('proveedor-edit',data)
			},
			deleteProductos(data){
			EventBus.$emit('producto-delete',data)
			}
		},
}
</script>

<style scoped>
	/*.contenido{ 
			margin: 0;
			padding: 0;
			height: 100%;
			background: #60a3bc !important;
		}*/
		.logo {
			top: 80px;
			height: 400px;
			width: 350px;
			margin-top: auto;
			margin-bottom: auto;
			background: #7756d1;
			position: relative;
			display: flex;
			justify-content: center;
			flex-direction: column;
			padding: 10px;
			border-radius: 5px;

		}
		.logo_container {
			position: absolute;
			height: 170px;
			width: 170px;
			top: -75px;
			border-radius: 50%;
			background: #60a3bc;
			padding: 10px;
			text-align: center;
		}
		.brand_logo {
			height: 150px;
			width: 150px;
			border-radius: 50%;
			border: 2px solid white;
		}
		.form_container {
			margin-top: 100px;
		}
		.login_btn {
			width: 100%;
			background: #c0392b !important;
			color: white !important;
		}
		.login_btn:focus {
			box-shadow: none !important;
			outline: 0px !important;
		}
		.login_container {
			padding: 0 2rem;
		}
		.input-group-text {
			background: #c0392b !important;
			color: white !important;
			border: 0 !important;
			border-radius: 0.25rem 0 0 0.25rem !important;
		}
		.input_user,
		.input_pass:focus {
			box-shadow: none !important;
			outline: 0px !important;
		}
		.custom-checkbox .custom-control-input:checked~.custom-control-label::before {
			background-color: #c0392b !important;
		}
</style>