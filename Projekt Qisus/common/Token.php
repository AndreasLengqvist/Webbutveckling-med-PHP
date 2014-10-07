<?php


class Token{
	
	private $token;


	public function setToken(){
		$salt = "al321";
		$this->token = sha1(uniqid($salt, true));
	}

	public function getToken(){
		return $this->token;
	}
}