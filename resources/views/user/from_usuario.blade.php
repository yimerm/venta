	<div class="form-group"> 
		<div class="input-group input-group-lg">
			<div class="input-group-prepend">
				<div class="input-group-text">Nombre</div>
			</div>
			<input type="text" @isset($user->nombre) value="{{ $user->nombre }}" @endisset name="nombre" class="form-control" placeholder="Nombre">
		</div>
	</div> 

	<div class="form-group"> 
		<div class="input-group input-group-lg">
			<div class="input-group-prepend">
				<div class="input-group-text">Apellidos</div>
			</div>
			<input type="text" @isset($user->apellidos) value="{{ $user->apellidos }}" @endisset name="apellidos" class="form-control" placeholder="Apellidos">
		</div>
	</div> 

	<div class="form-group"> 
		<div class="input-group input-group-lg">
			<div class="input-group-prepend">
				<div class="input-group-text">#Celular</div>
			</div>
			<input type="text" @isset($user->celular) value="{{ $user->celular }}" @endisset name="celular" class="form-control" placeholder="#Celular">
		</div>
	</div> 

	<div class="form-group"> 
		<div class="input-group input-group-lg">
			<div class="input-group-prepend">
				<div class="input-group-text">Direccion</div>
			</div>
			<input type="text" @isset($user->direcion) value="{{ $user->direcion }}" @endisset name="direcion" class="form-control" placeholder="ej: calle X # XX-XX Barrio X">
		</div>
	</div> 

	<div class="form-group"> 
		<div class="input-group input-group-lg">
			<div class="input-group-prepend">
				<div class="input-group-text">Monto del credito</div>
			</div>
			<input type="text" @isset($user->monto_deuda) value="{{ $user->monto_deuda }}" @endisset name="monto_deuda" class="form-control" placeholder="ej: Deuda maxima $ 450.000">
		</div>
	</div> 

	<div class="form-group"> 
		<div class="input-group input-group-lg">
			<div class="input-group-prepend">
				<div class="input-group-text">Imagen</div>
			</div>
			<input type="file" name="imagenusu" class="form-control">
		</div>
	</div>
