<?php

namespace model;


class Session{


	private $session = "SessionToken";


	public function setUniqSession(){
		$token = sha1(uniqid($salt, true));
		$_SESSION[$this->session] = $token;		
	}

	public function getUniqSession(){
		return $_SESSION[$this->session];
	}
}