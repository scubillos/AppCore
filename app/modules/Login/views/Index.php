<div id="wrapper">	
	<div class="container1">
		<h1 class="h1, text-center">LOGIN</h1>
	</div>
	<section>
		<div class="container">
			<form action="<?= $this->UrlBase(); ?>Login/Auth" method="post" autocomplete="off">
				<div class="form-group">
					<label for="usuario">Usuario: </label>
					<input type="text" name="usuario" class="form-control" id="usuario" placeholder="Usuario" required autofocus>
				</div>
				<div class="form-group">
					<label for="contraseña">Contraseña: </label>
					<input type="password" name="pass" class="form-control" id="contraseña" placeholder="Contraseña" required>
				</div>
				<center><button type="submit" name="boton" class="btn btn-success">Enviar</button></center>
			</form>
		</div>
	</section>
</div>