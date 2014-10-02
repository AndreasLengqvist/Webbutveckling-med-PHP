<?php

require_once("./common/CustomExceptions.php");


class RegisterModel{

	const regEx = '/[^a-z0-9\-_\.]/i';
	const minUsername = 3;
	const minPassword = 6;


	public function setUsername($username){

		// Om användarnamnet är för kort (mindre än 3).
		if(mb_strlen($username) < self::minUsername){
			throw new \TooShortException(3);		
		}
		// Om användarnamnet innehåller ogiltiga tecken.
		if(preg_match(self::regEx, $username)){
			$username = preg_replace(self::regEx, "", $username);
			throw new \InvalidCharException($username);	
		}
		// Om alla tester går igenom.
		return $username;
	}

	public function setPassword($password){
		// Om lösenordet är för kort (mindre än 6).
		if(mb_strlen($password) < self::minPassword){
			throw new \TooShortException(6);		
		}
		// Om alla tester går igenom.
		return $password;
	}
}