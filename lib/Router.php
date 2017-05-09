<?php
class Router{
	
	private static $app_path = "";
	private static $sys_path = "";
	private static $object = "";
	
	private function __construct(){}
	
	public static function getAction($url,$app_path,$sys_path){
		//Se setea el app_path y el sys_path
		static::setAppAndSysPaths($app_path,$sys_path);
		//Se obtiene la url, la cual es el controlador
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
		if(!static::routeExists($Controller)){
			throw new Exception("The controller ".$Controller." is not found in the application");
		}
		//Se valida que el metodo exista
		if(!static::methodExists($Controller,$Method)){
			throw new Exception("The method ".$Method." is not found in the controller");
		}
		//Se dispara la accion
		static::dispatchAction($Method,$Params);
	}
	
	private static function setAppAndSysPaths($app_path,$sys_path){
		static::$app_path = $app_path;
		static::$sys_path = $sys_path;
	}
	
	private static function routeExists($Controller){
		return file_exists(static::$app_path."modules/".$Controller."/controllers/".$Controller.".php");
	}
	
	private static function methodExists($Controller,$Method){
		//Se definen las constantes del modulo para ser utilizadas en el controlador
		define("CONTROLLER_CALLED",$Controller);								//Controlador actual
		define("METHOD_CALLED",$Method);										//Metodo llamado
		define("MODULE_USED",static::$app_path."modules/".$Controller."/");		//Modulo actual
		//Se hace el llamado al controlador incluyendo la clase del controlador base
		$routeClass = static::$app_path."modules/".$Controller."/controllers/".$Controller.".php";
		require_once($routeClass);
		class_alias($Controller, "ControllerLoaded");
		static::$object = new ControllerLoaded;
		return method_exists(static::$object,$Method);
	}
	
	private static function dispatchAction($Method,$Params){
		//Se verifica si contiene o no parametros para utilizar la funcion correcta en el llamado del metodo
		if(count($Params)==0){
			call_user_method($Method,static::$object);
		}else{
			call_user_method_array($Method,static::$object,$Params);
		}
	}
	
}

?>