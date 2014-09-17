<?php


class LoginModel{
	private $sessionLoginData = "LoginModel::LoggedInUserName";
	private $username = "user";
	private $password = "pass";

	public function __construct(){


	}

	// Hämtar vem som är inloggad.
	public function getLoggedInUser(){
		return $_SESSION[$this->sessionLoginData];
	}

	// Kontrollerar om sessions-varibeln är satt vilket betyder att en användare är inloggad.
	public function userLoggedIn(){

		if(isset($_SESSION[$this->sessionLoginData])){
			return true;
		}
		else{
			return false;
		}
	}

	// Kontrollerar att inmatat användarnamn och lösenord stämmer.
	public function checkLogin($clientUsername, $clientPassword){

		// Krypterat lösenord vid cookie-inloggning.
		$cryptedPassword = "$1\$PWfafBSP\$cTasIoeEzfIRCMNjg1ZBX0";

		if($clientUsername === $this->username && ($clientPassword === $this->password || $clientPassword === $cryptedPassword) ){

			// Sparar ner det inloggade användarnamnet till sessionen.
			$_SESSION[$this->sessionLoginData] = $clientUsername;		
			return true;
		}
		else{
			throw new \Exception("Felaktigt användarnamn och/eller lösenord!");
		}
	}

	public function logOut(){
		unset($_SESSION[$this->sessionLoginData]);
		session_destroy();
	}
}