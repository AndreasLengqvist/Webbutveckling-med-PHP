<?php

namespace model;


class CreateSession{


	private $session = "CreateSession";



	public function createSessionIsset(){
		return isset($_SESSION[$this->session]);
	}


	public function setCreateSession($session){
		$_SESSION[$this->session] = $session;		
	}


	public function getCreateSession(){
		return $_SESSION[$this->session];
	}


	public function unSetCreateSession(){
		unset($_SESSION[$this->session]);
	}
}