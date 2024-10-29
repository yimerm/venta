<template>
	<div>
		<nav class="navbar navbar-expand-lg">
		  <div class="collapse navbar-collapse" id="navbarSupportedContent">
		    <ul class="navbar-nav mr-auto">
					<li class="nav-item" style="color: black;">
						<router-link class="nav-link" :to="{name: 'tablero'}">
						<i class="fas fa-store fa-2x"></i>Ximer</router-link>
					</li>
					<!--
					<li class="nav-item" style="color: black;">
						<router-link class="nav-link" :to="{name: 'venta'}">Venta</router-link>
					</li>
					
					<li class="nav-item">
		        <router-link class="nav-link" :to="{name: 'factura'}">Facturas</router-link>
		      </li>
		      <li class="nav-item">
		        <router-link class="nav-link" :to="{name: 'categoria'}">Categoria</router-link>
		      </li>
		       <li class="nav-item">
		        <router-link class="nav-link" :to="{name: 'proveedor'}">Proveedor</router-link>
		      </li>
		       <li class="nav-item">
		        <router-link class="nav-link" :to="{name: 'productos'}">Productos</router-link>
		      </li>
		       <li class="nav-item">
		        <router-link class="nav-link" :to="{name: 'clientes'}">Clientes</router-link>
		      </li>
		      <li class="nav-item">
		        <router-link class="nav-link" :to="{name: 'entradafactura'}">inventario</router-link>
		      </li>
					-->
		      <li class="nav-item dropdown">
		        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		        {{usuariologiado}}
		        </a>
		        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
		          <a class="dropdown-item" href="#">Cerar secion</a>
		          <a class="dropdown-item" href="#">opciones</a>
		        </div>
		      </li>
		    </ul>
		  </div>
		</nav>
		<br>
	</div>
</template>
<style>
.navbar {
	background-color: #6b8fea;
}
.nav-link { 
	color: #090909;
	text-size-adjust: 50px; 
	}
	.nav-link:hover{

	color: #090909; 
}
</style>
