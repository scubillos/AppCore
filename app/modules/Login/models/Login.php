<?php

use Base\Model as Model;

class LoginModel Extends Model{
	protected $table = "users";
	
	protected $fields = ["id","nombre","edad","correo"];
}
?>