<?php
	/***
	 Archivo en el cual se carga el ROUTE para visualizar las paginas correctamente
	 
	 Las siguientes constantes ya se encuentran presentes en este paso:
	 - APP_PATH = Path del aplicativo (Controladores, Vistas, Modelos)
	 - SYS_PATH = Path del sistema
	**/
	chdir(dirname(__DIR__));
	
	require SYS_PATH."Router.php";
	
	$url = $_GET["url"];
	if($url=="index.php"){
		$url = $config["INITIAL_CONTROLLER"];
		if($config["INITIAL_METHOD"]!=""){
			$url .= "/".$config["INITIAL_METHOD"];
		}
	}
	
	try{	
		Router::getAction($url,APP_PATH,SYS_PATH);	
	}catch(Exception $e){
		echo $e->getMessage();
	}
?>