<?php
namespace Base;

class DB{
	private function __construct(){}
	
	private static function connection(){
		require(APP_PATH."/config/database.php");
		
		$connection = null;
		try{
			$connection = new \PDO("mysql:host=".$database["HOST"].";dbname=".$database["DB_NAME"],$database["USER"],$database["PASSWORD"]);
		}catch(\PDOException $e){
			die($e->getMessage());
		}
		
		return $connection;
	}
	
	public static function query($sql,$params = []){
		try{
			$statement = static::connection();
			$prepareStatement = $statement->prepare($sql);
			$prepareStatement->execute($params);
			$result = [];
			if(static::verifyStatusExecute($prepareStatement)){
				/*
				if($prepareStatement->fetchColumn() > 0){
					if($prepareStatement->fetchColumn() == 1){
						$result[0] = $prepareStatement->fetch();
						var_dump($result);
					}else{
						while($row = $prepareStatement->fetch()){
							$result[] = $row;
						}
					}
				}*/
				
				$result = $prepareStatement->fetchAll();
			}
		}catch(\PDOException $e){
			die($e->getMessage());
		}
		return $result;
	}
	
	public static function verifyStatusExecute($prepareStatement){
		$status = $prepareStatement->errorInfo();
		if(is_array($status) AND count($status)!=0){
			if($status[0]!="00000"){
				throw new \Exception("Error #".$status[0]." => ".$status[2]);
			}
		}
		return true;
	}
	
	public static function insert($sql,$params = []){
		$lastInsertId = 0;
		try{
			$statement = static::connection();
			$prepareStatement = $statement->prepare($sql);
			$prepareStatement->execute($params);
			
			if(static::verifyStatusExecute($prepareStatement)){
				$lastInsertId = $statement->lastInsertId();
			}
		}catch(\PDOException $e){
			die($e->getMessage());
		}		
		return $lastInsertId;
	}
}
?>