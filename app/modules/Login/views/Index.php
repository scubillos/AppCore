<span class="Apple-style-span" style="font-family: 'Trebuchet MS', sans-serif;">HOLA A TODOS
</span>
</br></br></br>
<span class="Apple-style-span" style="font-family: 'Trebuchet MS', sans-serif;">AQUI YA SE CARGO LA VISTA DEL INDEX DEL LOGIN
<ul>
	<div>Variables enviadas desde el controlador</div>
	<?php 
	echo isset($numero) ? '<li>numero: '.$numero.'</li>' : "";
	echo isset($string) ? '<li>string: '.$string.'</li>' : "";
	?>
</ul>
</span>