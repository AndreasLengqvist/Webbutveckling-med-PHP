<?php


namespace model;

require_once("./config.php");


// Kodstruktur snodd av Emil Carlsson, föreläsning 6 - Webbutveckling med PHP.
abstract class Repository {

	protected $dbConnection;
	protected $dbTable;
	

	
	protected function connection() {
		if ($this->dbConnection == NULL)
			$this->dbConnection = new \PDO(\Config::$DB_CONNECTION, \Config::$DB_USERNAME, \Config::$DB_PASSWORD);
		
		$this->dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		
		return $this->dbConnection;
	}
}