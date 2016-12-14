<?php

/**
* 
*/
class DbController{
	
	protected static function getConnection(){
		$database_host = DB_HOST;
		$database_port = DB_PORT;
		$database_username = DB_USER;
		$database_password = DB_PASS;
		$database_name = DB_NAME;

		$con = pg_connect("host=$database_host port=$database_port dbname=$database_name user=$database_username");

		// Check connection
		if(!$con){
			die("Could not connect to Postgres");
		}
		return $con;
	}

	protected static function arrayFromResult($result): array{
		$data = array();
		while($row = pg_fetch_array($result, null, PGSQL_ASSOC)){
			$data[] = $row;
		}
		return $data;
	}

	public static function select(string $query): array{
		$con = self::getConnection();
		$result = pg_query($con, $query) or die(pg_last_error($con));
		pg_close($con);
		
		return self::arrayFromResult($result);
	}

	public static function selectOne(string $query, string $model, string $id): array{
		$con = self::getConnection();
		
		$preparedQueryName = $model::filename().'_select_one';
		pg_prepare($con, $preparedQueryName, $query) or die(pg_last_error($con));
		$result = pg_execute($con, $preparedQueryName, array($id)) or die(pg_last_error($con));
		
		pg_close($con);
		
		$data = self::arrayFromResult($result);
		if(!empty($data)){
			$data = $data[0];
		}
		return $data;
	}
}