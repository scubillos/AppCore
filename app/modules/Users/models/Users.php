<?php

use Base\Model as Model;

class UsersModel Extends Model{
	protected $table = "users";
	
	protected $fields = ["id","nombre","edad","correo"];
}
?>