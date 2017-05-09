<?php
namespace Base;

class Session{
	public function __construct(){}
	
	public function verifyLogin(){
		session_start();
		if(!isset($_SESSION)){
			session_destroy();
			parent::callAction("Login");
		}
		return true;
	}
	
	public function varSession_set($nameVar,$valueVar){
		session_start();
		$_SESSION[$nameVar] = $valueVar;
	}
	
	public function varSession_get($nameVar){
		session_start();
		return $_SESSION[$nameVar];
	}
}
?>