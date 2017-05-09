<?php

/***
 Clase Base para los modelos, contendra funciones fundamentales para el uso del mismo tales como:
	- Conexion a base de datos
 Las siguientes constantes ya se encuentran presentes en este paso:
	 - APP_PATH = Path del aplicativo (Controladores, Vistas, Modelos)
	 - SYS_PATH = Path del sistema
***/

namespace Base;

class Model{
	// Variables necesarias para realizar consultas y operaciones con la tabla
	protected $table = "";
	protected $primaryKey = "id";
	protected $fields = [];
	
	// Consultas
	public static function find($keyValue){
		$model = new static();
		
		$sql = "select * from ".$model->table." where ".$model->primaryKey." = :key ";
		$params = [":key" => $keyValue ];
		$result = DB::query($sql,$params);
		foreach($result as $key => $value){
			if(in_array($key,$model->fields)){
				$model->$key = $value;
			}
		}
		return $model;
	}
	public static function rawQuery($sql){
		$model = new static();
		
		$result = DB::query($sql);
		foreach($result as $key => $value){
			if(in_array($key,$model->fields)){
				$model->$key = $value;
			}
		}
		return $model;
	}
	public static function where($data = []){
		$model = new static();
		
		$params = [];
		$where = "";
		foreach($data as $field => $value){
			if($where!=""){
				$where .= " AND ";
			}
			
			if(is_array($value)){
				foreach($value as $operator => $val){
					$where .= "(".$field." ".$operator." :".$field.")";
					$params[$field] = $val;
				}
			}else{
				$where .= "(".$field." = :".$field.")";
				$params[$field] = $value;
			}
		}
		
		$sql = "select * from ".$model->table." where ".$where;
		
		//die($sql);
		$result = DB::query($sql,$params);
		if(is_object($result)){
			foreach($result as $key => $value){
				if(in_array($key,$model->fields)){
					$model->$key = $value;
				}
			}
		}else if(is_array($result)){
			$model->rows = [];
			$k = 0;
			foreach($result as $row){
				foreach($row as $key => $value){
					if(in_array($key,$model->fields)){
						$model->rows[$k]->$key = $value;
					}
				}
				$k++;
			}
		}
		var_dump($model);
		return $model;
	}
	
	// Insert
	public static function insert($data = []){
		$model = new static();
		
		$fields = [];
		foreach($data as $field){
			$fields[] = $field;
		}
		$stringFields = implode(",",$fields);
		$stringHidden = implode(",:",$fields);
		
		$sql = "insert into ".$model->table." (".$stringFields.") values (:".$stringHidden.") ";
		//die($sql);
		$lastInsertId = DB::insert($sql,$data);
		
		$result = $model->find($lastInsertId);
		print_r($result);
		return $result;
	}
}

?>