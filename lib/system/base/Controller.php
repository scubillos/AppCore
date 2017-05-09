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
namespace Base;

class Controller{
	
	//Funcion para cargar un modelo
	public function LoadModel($model = ""){
		$model = $model != "" ? $model : CONTROLLER_CALLED;		// Si $model esta vacia significa que se esta llamando al modelo que se llama igual al controlador actual
		$nameModel = $model."Model";
		$routeModelModule = MODULE_USED."models/".$model.".php";
		if(is_file($routeModelModule)){
			// Vista del Modulo actual
			$routeModel = $routeModelModule;
		}else{
			if(strpos($model,"/") !== false){			// Con slashes ignificaria que se esta llamando el modelo de otro modulo
				$modelInfo = explode("/",$model);
				$module = $modelInfo[0];
				$model2 = $modelInfo[1];
				$nameModel = $model2."Model";
				
				$routeModelApp = APP_PATH."modules/".$module."/models/".$model2.".php";
				if(is_file($routeModelApp)){
					$routeModel = $routeModelApp;
				}else{
					throw new Exception("The model ".$model." is not found in the application");
				}
			}else{
				throw new Exception("The model ".$model." is not found in the module application");
			}
		}
		include($routeModel);
		$objModel = new $nameModel;
		return $objModel;
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
		//Se le pasan los parametros a la vista
		if(count($parameters)!=0){
			foreach($parameters as $k => $v){
				$$k = $v;
			}
		}
		unset($routeViewModule);
		require($routeView);
		unset($routeView);
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
	
	//Funcion para cargar CSS
	public function AddCSS($stylesheet){
		$headHTML = "";
		if(!is_array($stylesheet)){
			$stylesheet = [$stylesheet];
		}
		foreach($stylesheet as $css){
			$strExt = strtolower(substr($css,-4)) != ".css" ? ".css" : "";
			$css = $css.$strExt;
			$routeInApplication = APP_PATH.$css;
			if(is_file($routeInApplication)){
				$headHTML .= '<link rel="stylesheet" type="text/css" href="'.URL_APP.$routeInApplication.'" />';
			}else{
				throw new Exception("The CSS file ".$css." is not found in the application");
			}
		}
		
		echo $headHTML;
	}
	
	//Funcion para obtener url base del aplicativo
	public function UrlBase(){
		return URL_APP;
	}
}

?>