<?php

use Base\Controller as Controller;

class Login Extends Controller{
	public $titlePage = "Login"; //Para el titulo de la pagina
	
	public function __construct(){
		parent::__construct();
	}
	
	public function Index(){
		$this->RenderView("Index");
	}
	
	public function Auth(){
		if($_POST){
			$nombre = $_POST["usuario"];
			$users = $this->LoadModel("Users/Users");
			$users = $users->where([ "nombre" => $nombre ])->toArray();
			if(count($users)==1){
				$idbin = decbin($users[0]["id"]);
				$nombreus = $users[0]["nombre"];
				$this->session->varSession_set("idbin",$idbin);
				$this->session->varSession_set("nombre",$nombreus);
				$this->redirect("Home");
			}
		}
	}
}

?>