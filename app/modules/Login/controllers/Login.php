<?php

use Base\Controller as Controller;

class Login Extends Controller{
	var $Login;
	public function __construct(){
		$this->Login = $this->LoadModel();
	}
	
	public function Index(){		
		$this->AddCSS('modules/Login/assets/css/prueba_estilos.css');
		$this->RenderView("Index");
		
		$where = [
			"id" => [ "<" => 10]
		];
		
		$users = $this->Login->where($where);
	}
	
	public function Crear(){
		if($_POST){
			//var_dump($_POST);
			
			$this->Login->insert($_POST);
		}
		$this->RenderView("Formulario");
	}
	
}

?>