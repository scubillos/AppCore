<?php
use Base\Controller as Controller;

class Home Extends Controller{
	
	public function Index(){
		$this->RenderView("Home/Index");
	}
	
	public function Info(){
		$this->AddJS('modules/Login/assets/js/prueba.js');
		
		$this->RenderView();
	}
	
}

?>