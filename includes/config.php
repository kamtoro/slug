<?php

/** 
* Filename: config.php 
* Purpose: 	Connecting to the mysql database
* Author: 	Camilo Toro (new slug)
* Date: 	July 27, 2016
*/

class Config{
  
 // specify your own database credentials
 private $host = "localhost";
 private $db_name = "slug";
 private $username = "slugadmin";
 private $password = "8cRBpGUEFqtRTaKx";
 public $conn;
  
 // get the database connection
	 public function getConnection(){
		$this->conn = null;
		try{
			$this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
		}catch(PDOException $exception){
			echo "Connection error: " . $exception->getMessage();
		}
		return $this->conn;
	}

	public function closeConnection(){
		$this->conn = null;
		return null;
	}
}
?>