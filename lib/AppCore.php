<?php
	/***
	 Clase que permite la inicializacion del aplicativo
	**/
	
	class AppCore{
		// Constructor de AppCore
		public function __construct(){
			include("app/config/config.php");
			$url = $this->getUrl();
			$_GET["url"] = null;
			unset($_GET["url"]);
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
		}
		
		public function getUrl(){			
			if(isset($_GET["url"])){
				return $_GET["url"];
			}
		}		
	}
?>