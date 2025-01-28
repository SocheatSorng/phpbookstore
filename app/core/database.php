<?php 

Class Database
{
	public function db_connect()
	{
		try {
			// Check if PDO MySQL driver is available
			if (!extension_loaded('pdo_mysql')) {
				throw new Exception('PDO MySQL driver is not installed');
			}

			$string = DB_TYPE .":host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8";
			$db = new PDO($string, DB_USER, DB_PASS, [
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
			]);
			return $db;
			
		} catch(PDOException $e) {
			die("Connection failed: " . $e->getMessage());
		} catch(Exception $e) {
			die("Error: " . $e->getMessage());
		}
	}

	public function read($query,$data = [])
	{

		$DB = $this->db_connect();
		$stm = $DB->prepare($query);

		if(count($data) == 0)
		{
			$stm = $DB->query($query);
			$check = 0;
			if($stm){
				$check = 1;
			}
		}else{

			$check = $stm->execute($data);
		}

		if($check)
		{
			$data = $stm->fetchAll(PDO::FETCH_OBJ);
			if(is_array($data) && count($data) > 0)
			{
				return $data;
			}

			return false;
		}else
		{
			return false;
		}
	}

	public function write($query,$data = [])
	{

		$DB = $this->db_connect();
		$stm = $DB->prepare($query);

		if(count($data) == 0)
		{
			$stm = $DB->query($query);
			$check = 0;
			if($stm){
				$check = 1;
			}
		}else{

			$check = $stm->execute($data);
		}

		if($check)
		{
			return true;
		}else
		{
			return false;
		}
	}


}