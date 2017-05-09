<span class="Apple-style-span" style="font-family: 'Trebuchet MS', sans-serif;">CREAR USUARIO</span>
<hr>
<form action="<?= $this->UrlBase(); ?>Login/Crear" method="post">
	<input name="nombre" placeholder="Nombre" />
	<br>
	<input name="edad" placeholder="Edad" />
	<br>
	<input name="correo" placeholder="Correo" />
	<br>
	<input type="submit" value="Guardar" />
</form>