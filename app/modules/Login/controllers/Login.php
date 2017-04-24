<?php

class Login Extends Controller{
	
	public function Index(){		
		$this->RenderView();
	}
	
	public function Info(){
		//$this->AddJS('modules/Login/assets/js/prueba.js');
		$data["numero"] = 456;
		$data["string"] = "Mi framework";
		$this->RenderView("Index",$data);
	}
	
}

?>