<?php

namespace model;

require_once("./common/CustomExceptions.php");


class RegisterModel{


	const regEx = '/[^a-z0-9\-_\.]/i';
	const minUsername = 3;
	const minPassword = 6;


	// Sätter användarnamnet ifall det går igenom alla kontroller.
	public function setUsername($username){

		// Om användarnamnet är för kort (mindre än 3).
		if(mb_strlen($username) < self::minUsername){
			throw new \TooShortException(self::minUsername);		
		}
		// Om användarnamnet innehåller ogiltiga tecken.
		if(preg_match(self::regEx, $username)){
			$username = preg_replace(self::regEx, "", $username);
			throw new \InvalidCharException($username);	
		}

		return $username;
	}

	// Sätter lösenodet ifall det går igenom alla kontroller. (Kryptering fattas)
	public function setPassword($password){

		// Om lösenordet är för kort (mindre än 6).
		if(mb_strlen($password) < self::minPassword){
			throw new \TooShortException(self::minPassword);		
		}

		return $password;
	}
}