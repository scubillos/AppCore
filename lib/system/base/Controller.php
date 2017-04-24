<?php

/***
 Clase Base para los controladores, contendra funciones fundamentales para el uso del mismo tales como:
	- Cargar Modelo
	- Cargar Vistas
	- Cargar JS (Custom)
	- Cargar CSS (Custom)
	- Cargar Plugins
 
 Para conocer el nombre del controlador que esta invocando esta clase, metodo llamado, carpeta del modulo utilizar las constantes:
	- CONTROLLER_CALLED = Controlador llamado
	- METHOD_CALLED = Metodo llamado
	- MODULE_USED = Modulo que se esta utilizando
***/

class Controller{
	
	//Funcion para cargar el modelo correspondiente al controlador, es decir el modelo que contiene el mismo nombre que el controlador.
	public function LoadThisModel($model = ""){
	}
	
	//Funcion para cargar un modelo de otro modulo
	public function LoadModel($model = ""){
	}
	
	//Funcion para cargar la vista		
	public function RenderView($view = "", $parameters = []){
		$view = $view != "" ? $view : METHOD_CALLED;	// Si la vista viene vacia se busca una que se llame como el metodo
		
		$routeViewModule = MODULE_USED."views/".$view.".php";
		if(is_file($routeViewModule)){
			// Vista del Modulo actual
			$routeView = $routeViewModule;
		}else{
			if(strpos($view,"/") !== false){			// Con slashes ignificaria que se esta llamando la vista de otro modulo
				$viewInfo = explode("/",$view);
				$module = $viewInfo[0];
				$view2 = $viewInfo[1];
				
				$routeViewApp = APP_PATH."modules/".$module."/views/".$view2.".php";
				if(is_file($routeViewApp)){
					$routeView = $routeViewApp;
				}else{
					throw new Exception("The view ".$view." is not found in the application");
				}
			}else{
				throw new Exception("The view ".$view." is not found in the module application");
			}
		}
		require($routeView);
	}
	
	//Funcion para cargar JS
	public function AddJS($javascript){
		$headHTML = "";
		if(!is_array($javascript)){
			$javascript = [$javascript];
		}
		foreach($javascript as $js){
			$strExt = strtolower(substr($js,-3)) != ".js" ? ".js" : "";
			$js = $js.$strExt;
			$routeInApplication = APP_PATH.$js;
			if(is_file($routeInApplication)){
				$headHTML .= '<script type="text/javascript" src="'.URL_APP.$routeInApplication.'" ></script>';
			}else{
				throw new Exception("The JS file ".$js." is not found in the application");
			}
		}
		
		echo $headHTML;
	}
}

?>