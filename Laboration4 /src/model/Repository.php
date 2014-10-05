<?php


namespace model;


// Kodstruktur snodd av Emil Carlsson, föreläsning 6 - Webbutveckling med PHP.
abstract class Repository {
	protected $dbUsername = 'alengqvist_com';
	protected $dbPassword = 'al223bn';
	protected $dbConnstring = 'mysql:host=localhost;dbname=alengqvist_com';
	protected $dbConnection;
	protected $dbTable;
	
	protected function connection() {
		if ($this->dbConnection == NULL)
			$this->dbConnection = new \PDO($this->dbConnstring, $this->dbUsername, $this->dbPassword);
		
		$this->dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		
		return $this->dbConnection;
	}
}