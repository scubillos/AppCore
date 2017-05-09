<?php

namespace Theme;

class Template{
	//Clase para generar el template del aplicativo
	protected static $theme = "default";
	
	protected static function __construct(){
		require(APP_PATH."config/config.php");
		static::theme = $config["THEME"] != "" ? $config["THEME"] : static::theme;
	}
	
	protected static function navbar(){
		$routeNavbar = URL_APP."public/themes/".static::theme."/navbar.php";
		require_once($routeNavbar);
	}
	
	protected static function sidebar(){
		$routeSidebar = URL_APP."public/themes/".static::theme."/sidebar.php";
		require_once($routeSidebar);
	}
}
?>