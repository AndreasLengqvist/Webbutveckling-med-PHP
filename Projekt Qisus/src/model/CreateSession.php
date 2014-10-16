<?php

namespace model;


class CreateSession{


	private $createSession = "CreateSession";
	private $titleSession = "titleSession";



	public function createSessionIsset(){
		return isset($_SESSION[$this->createSession]);
	}

	public function titleSessionIsset(){
		return isset($_SESSION[$this->titleSession]);
	}


	public function setCreateSession($session){
		$_SESSION[$this->createSession] = $session;		
	}

	public function setTitleSession($session){
		$_SESSION[$this->titleSession] = $session;		
	}


	public function getCreateSession(){
		if ($this->createSessionIsset()) {
			return $_SESSION[$this->createSession];
		}
	}

	public function getTitleSession(){
		if ($this->titleSessionIsset()) {
			return $_SESSION[$this->titleSession];
		}
	}

	public function unSetCreateSession(){
		unset($_SESSION[$this->titleSession]);
		unset($_SESSION[$this->createSession]);
	}
}