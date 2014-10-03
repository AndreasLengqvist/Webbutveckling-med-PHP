<?php

namespace model;

require_once("Repository.php");


class RegisterRepository extends Repository{

	private $db;
	private static $id = "id";
	private static $username = "username";
	private static $password = "password";


	public function __construct(){
		$this->dbTable = "user";
	}

	public function create(User $registerData){
		// Här kollas även om användarnamnet redan är reggat, if-sats innan.
			try{
				$db = $this->connection();

            	$sql = "INSERT INTO $this->dbTable (" . self::$username . ", " . self::$password . ") VALUES (?, ?)";

				$params = array($registerData->getUsername(), $registerData->getPassword());

				$query = $db->prepare($sql);
			
				$query->execute($params);

			} catch (\Exception $e) {
				var_dump($e);
				die("An error occured in the database when creating user!");
			}
	}

}