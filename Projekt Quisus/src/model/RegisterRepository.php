<?php

namespace model;

require_once("Repository.php");


class RegisterRepository extends Repository{

	private $db;
	private static $username = "username";
	private static $password = "password";


	public function __construct(){
		$this->dbTable = "user";
	}

	public function create(User $registerData){
		try{
			$db = $this->connection();

        	$sql = "INSERT INTO $this->dbTable (" . self::$username . ", " . self::$password . ") VALUES (?, ?)";

			$params = array($registerData->getUsername(), $registerData->getPassword());

			$query = $db->prepare($sql);
		
			$query->execute($params);

		} catch (\Exception $e) {
			die("An error occured in the database!");
		}
	}

	public function usernameExists($clientUsername){
		try{
			$db = $this->connection();

        	$sql = "SELECT * FROM $this->dbTable WHERE " . self::$username . " = ?";

			$params = array($clientUsername);

			$query = $db->prepare($sql);

			$query->execute($params);

			$result = $query->fetch();

			if (strtolower($result[self::$username]) === strtolower($clientUsername)) {
				return true;
			}

		} catch (\Exception $e) {
			die("An error occured in the database!");
		}
	}

}