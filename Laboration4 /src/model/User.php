<?php

namespace model;

require_once("./common/CustomExceptions.php");


class User{

	/*
	Errocodes:
		202 - AllTooShortException
		203 - UsernameTooShortException
		204 - InvalidCharException
		205 - NoMatchException
		206 - PasswordTooShortException
	*/

	private $username;
	private $password;

	const regEx = '/[^a-z0-9\-_\.]/i';
	const minUsername = 3;
	const minPassword = 6;


	// Validerar och sätter användarnamn och lösenord.
	public function __construct($username, $password, $rpassword){

		// Om både användarnamn och båda lösenorden är för korta.
        if(mb_strlen($username) < self::minUsername && mb_strlen($password) < self::minPassword && mb_strlen($rpassword) < self::minPassword){
            throw new \TooShortException("Errorcode: ", 202);
        }
		// Om användarnamnet är för kort.
		if(mb_strlen($username) < self::minUsername){
			throw new \TooShortException("Errorcode: ", 203);		
		}
		// Om användarnamnet innehåller ogiltiga tecken.
		if(preg_match(self::regEx, $username)){
			$username = preg_replace(self::regEx, "", $username);
			throw new \InvalidCharException($username, 204);	
		}
		// Om lösenordet är för kort.
		if(mb_strlen($password) < self::minPassword || mb_strlen($rpassword) < self::minPassword){
			throw new \TooShortException("Errorcode: ", 206);		
		}
		// Om lösenorden är olika.
        if($password !== $rpassword){
            throw new \NoMatchException("Errorcode: ", 205);
        }

		$this->username = $username;

		$this->password = $this->cryptPassword($password);
	}

	public function getUsername(){
		return $this->username;
	}

	public function getPassword(){
		return $this->password;
	}

	public function cryptPassword($password){
		$salt = "al321";
		return sha1($salt . $password);
	}
}