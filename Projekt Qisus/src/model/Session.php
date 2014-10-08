<?php

namespace model;


class Session{


	private $session = "QuizSession";



	public function sessionIsset(){
		return isset($_SESSION[$this->session]);
	}


	public function setSession($session){
		$_SESSION[$this->session] = $session;		
	}


	public function getSession(){
		return $_SESSION[$this->session];
	}
}