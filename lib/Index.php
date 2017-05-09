<?php
	/***
	 Se inicializa el Aplicativo
	 
	 Las siguientes constantes ya se encuentran presentes en este paso:
	 - APP_PATH = Path del aplicativo (Controladores, Vistas, Modelos)
	 - SYS_PATH = Path del sistema
	**/
	chdir(dirname(__DIR__));
	
	require SYS_PATH."Init.php";
	
	$AppCore = new AppCore;
?>