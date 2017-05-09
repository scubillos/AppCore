<?php
	/***
	 Archivo de configuracion de frontend. Es decir JS, CSS que se deben ejecutar siempre al cargar un controlador
	 
	 - Utilizar {NombreDeLaInstanciaQueSeCarga} => {RutaDelArchivoParaCargarInstancia}
	 - Las rutas deben partir desde la carpeta principal del aplicativo
	**/
	
	$frontend = [];
	$frontend = [
		//JS
		"JS" => [
			"jquery" => "app/generals/frontend/jquery/jquery-3.2.1.min.js",
			"bootstrap" => "app/generals/frontend/bootstrap/js/bootstrap.min.js",
			"lodash" => "app/generals/frontend/lodash/lodash.min.js"
		],
		"CSS" => [
			"bootstrap" => "app/generals/frontend/bootstrap/css/bootstrap.min.css",
			"theme_default" => "public/themes/default/css/estilosp.css",
		]
	];
	
?>