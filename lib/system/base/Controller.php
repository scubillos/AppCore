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
	public $titlePage = "";
	
	public $session = "";
	
	public function __construct(){
		$this->FrontEnd();
		$this->ClassSession();
	}
	
	//Se cargan JS,CSS,HTML
	public function FrontEnd(){
		$headHTML = '<!DOCTYPE html><html lang="es"><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"><meta http-equiv="X-UA-Compatible" content="ie=edge"><title>'.$this->titlePage.'</title>';
		//Se requiere el archivo con la configuracion de plugins y librerias generales
		require(APP_PATH."config/frontend.php");
		//Se generan los importadores de JS
		$JS = $frontend["JS"];
		foreach($JS as $nameJS => $routeJS){
			$headHTML .= '<script type="text/javascript" src="'.URL_APP.$routeJS.'" ></script>';
		}
		$CSS = $frontend["CSS"];
		//Se generan los importadores de CSS
		foreach($CSS as $nameCSS => $routeCSS){
			$headHTML .= '<link rel="stylesheet" type="text/css" href="'.URL_APP.$routeCSS.'" />';
		}
		echo $headHTML;
	}
	
	//Se carga la clase de session
	public function ClassSession(){
		require(SYS_PATH."system/Session.php");
		$this->session = new Session;
	}
	
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
					throw new \Exception("The model ".$model." is not found in the application");
				}
			}else{
				throw new \Exception("The model ".$model." is not found in the module application");
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
					throw new \Exception("The view ".$view." is not found in the application");
				}
			}else{
				throw new \Exception("The view ".$view." is not found in the module application");
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
				throw new \Exception("The JS file ".$js." is not found in the application");
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
				throw new \Exception("The CSS file ".$css." is not found in the application");
			}
		}
		
		echo $headHTML;
	}
	
	//Funcion para obtener url base del aplicativo
	public function UrlBase(){
		return URL_APP;
	}
	
	//Funcion para llamar metodo de otro controlador
	public function callAction($url){
		if($url == ""){
			throw new \Exception("The action called not is defined");
		}
		if(strpos($url,"/") !== false){ //Se intenta llamar una accion de otro controlador
			
			
			if(strpos($url,"/") !== false){
				//Contiene slashes la url
				$Action = explode("/",$url);
				$Controller = $Action[0];								//Controlador
				$Method = $Action[1] != '' ? $Action[1] : "Index";		//Metodo
				$Params = [];											//Parametros de la funcion
				if(count($Action)>2){
					for($key=2; $key<count($Action); $key++){
						if($Action[$key]!=''){
							$Params[] = $Action[$key];
						}
					}
				}
			}else{
				//No tiene ningun slash, solo nombre del controller tal vez
				$Controller = $url;		//Controlador
				$Method = "Index";		//Metodo
				$Params = [];			//Parametros de la funcion
			}
			
			//Se valida que el controlador exista
			if(!file_exists(APP_PATH."modules/".$Controller."/controllers/".$Controller.".php")){
				throw new \Exception("The controller ".$Controller." is not found in the application");
			}
			//Se valida que el metodo exista
			
			$routeClass = APP_PATH."modules/".$Controller."/controllers/".$Controller.".php";
			require_once($routeClass);
			$objectClassCalled = new $Controller;
			
			if(!method_exists($objectClassCalled,$Method)){
				throw new \Exception("The method ".$Method." is not found in the controller");
			}
			//Se dispara la accion
			if(count($Params)==0){
				call_user_method($Method,$objectClassCalled);
			}else{
				call_user_method_array($Method,$objectClassCalled,$Params);
			}
			
		}else{
			throw new \Exception("The action requires a controller and action separes with slashes");
		}
	}
	
	//Funcion para redireccionar
	public function redirect($url){
		header("location: ".URL_APP.$url);
	}
}

?>