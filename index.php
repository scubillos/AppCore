<?php
	include("app/config/config.php");

	define("URL_APP",$config["URL_APP"]);
	define("SYS_PATH","lib/");
	define("APP_PATH","app/");

	require_once(SYS_PATH."Index.php");
?>