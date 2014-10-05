<?php

namespace model;

require_once("Repository.php");


class LoginRepository extends Repository{

	private $db;
	private static $username = "username";
	private static $password = "password";


	public function __construct(){
		$this->dbTable = "user";
	}

	public function getUserByUsername($input){
		try {

			$db = $this->connection();

		  	$sql = "SELECT * FROM $this->dbTable WHERE " . self::$username . " = ?";
		    $params = array($input);

		    $query = $db->prepare($sql);
		    $query->execute($params);
		    $result = $query->fetch();

	    	return $result;

		} catch (Exception $e) {
			die("An error occured in the database!");
		}
	}
}