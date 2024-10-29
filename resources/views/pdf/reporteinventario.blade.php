<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>

	<style>
	.table {
		position: relative;
		top: 180px;
		width: 100%;
		text-align: left; 
		margin: 0 0 1em 0; 
	}
	.table tr td {
    width: 1%;
}
	th, td {
		text-align: center;
		border-bottom: 1px solid #999; 
	}
	.encabesado{
		width: 47rem;
		display: inline-block;
		height: auto;
		color: black;
	}
	#img {
		width: 12rem;
		position: relative;
	}
	#contenido{
		width: 33rem;
		position: relative;
	}
	#nomempresa{
		font-size: 250%
	}
	.datos_contenido{
		height: 7rem;
		top: 150px;
		border-style: double; 
		border-width: 1px;
	}
	.encabesa_2{
		position: relative;
		top:1.8rem;
		display: inline-block;
		width: 47rem;
	}
	#datos_cliente{
		width: 20rem;
		left: 15px;
	}
	#datos_factura{
		width: 20rem;
	}
	#numerofac{
		padding: 0;
		font-size: 180%
	}
	@page {
		margin: 100px 25px;
	}
	header {
		position: fixed;
		top: -70px;
		left: 0px;
		right: 0px;
		height: auto;
	}
	footer { 
		position: fixed; 
		bottom: -60px; 
		left: 0px; 
		right: 0px;
		height: auto;
		width: auto; 
	}
	#items{
		width: 10px;
	}
	#codigo{
		width: auto;
	}
	#nombre{
		width: auto;
	}
	#precio{
		width: auto;
	}
	#cantidad{
		width: auto;
	}
	#total{
		width: auto;
		text-align: right;
	}

	.itemsotros{
		position: relative; 
		width: 500px;
		height: 150px;
	}
	.tabletotal{ 
		position: absolute;
		text-align: right;
		top: 5px;
		left: 563px;
		width: auto;
	}
	.stylo{
		width: 120px; 
		text-align: left;
	}
	.valor{
		text-align: right;
	}
	.observaciones{ 
		border-style: dotted;
		width: 480px;
		height: 80px;
	}
	</style>
</head>
<body>
<header>
	<div class="encabesado" id="img">imagen</div>
	<div class="encabesado" id="contenido">
		<div id="nomempresa">YOKOMIRAY</div>
		<div id="nit">NIT: 66954130-3</div>
		<div id="direcion">Dire: Calle 21 # 28-44 san jorgue 2</div>
		<div id="celular">Celular: 3223090329</div>
		<div id="email">tienda245@gmail.com</div>
	</div>
	<div class="datos_contenido">
		<div class="encabesa_2" id="datos_cliente">
			<div id="nit">Nombre:{{ $datosclientes->nombre." ".$datosclientes->apellidos}}</div>
			<div id="nit">direcion:{{ $datosclientes->direcion}}</div>
			<div id="nit">nit:{{ $datosclientes->cedula}}</div>
			<div id="nit">celular:{{ $datosclientes->celular}}</div>
			<div id="nit">Vendedor:{{ $consultaidfactura->usuario}}</div>
		</div>
		<div class="encabesa_2" id="datos_factura">
			<div id="numerofac">Numero factura: {{ $numerofactura }}</div>
			<div id="fechaini">Fecha Facturacion : 13/nombiembre/2022</div>
			<div id="fechafinal">Fecha Vencimiento : 13/nombiembre/2022</div>
			<div id="formapago">Modo De Pago : {{ $consultaidfactura->modo_pago}}</div>
		</div>
	</div>
</header>
<footer> 
	<div class="datos_venta">
			<div class="itemsotros" >
				Items: {{$contadoritems}} ItemsProductos: {{$sumaProducto[0]->totalproductos}}</td><br>
				observaciones:
				<div class="observaciones"> 
				</div>
			</div>
			<div class="tabletotal" > 
				<table>
					<thead>
						<tr>
							<th class="stylo">subtotal factura</th> 
							 
							<td class="valor">{{number_format($consultaidfactura->total_factura, 0, ',', '.')}}</td>
						</tr>
						<tr>
							<th class="stylo">Pago con</th> 
							<td class="valor">{{number_format($consultaidfactura->pago_con, 0, ',', '.')}}</td>
						</tr>
						<tr>
							<th class="stylo">Cambio</th>
							<td class="valor">{{number_format($consultaidfactura->pago_con - $consultaidfactura->total_factura, 0, ',', '.')}}</td> 
						</tr>
						<tr>
							<th class="stylo">Saldo Cliente</th> 
							<td class="valor">{{number_format($consultaidfactura->saldo_efectivo, 0, ',', '.')}}</td> 
						</tr>
						<tr>
							<th class="stylo">total factura</th> 
							<td class="valor">{{number_format($consultaidfactura->total_factura, 0, ',', '.')}}</td>  
						</tr>
					</thead>
				</table>		
			</div> 
	</div>
</footer>
	<table class="table">
		<thead>
			<tr>
				
				<th id="items">items</th>
				<th>codigo</th>
				<th>nombre</th>
				<th>precio</th>
				<th>cantidad</th>
				<th>total</th>
			</tr>
		</thead>
		<tbody>
		<?php $i=1 ?>
			@foreach($detallefacturaventa as $consu)
			<tr>
				<td id="items">{{$i}}</td>
				<td id="codigo">{{$consu->codigo}}</td>
				<td id="nombre">{{$consu->nombre}}</td> 
				<td id="precio">{{number_format($consu->precio, 0, ',', '.')}}</td>
				<td id="cantidad">{{$consu->cantidades}}</td>
				<td id="total">{{number_format($consu->precio * $consu->cantidades, 0, ',', '.')}}</td>
			</tr>
			@if($i % 25 == 0)
			<div style="page-break-before: always;"> </div>
			@endif
			<?php $i++ ?>
			@endforeach
		</tbody>
	</table>
 
</body>
</html>