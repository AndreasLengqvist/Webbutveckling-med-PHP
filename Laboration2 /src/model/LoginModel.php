<?php


class LoginModel{
	private $sessionLoginData = "LoginModel::LoggedInUserName";
	private $username = "Admin";
	private $password = "Password";


	// Kontrollerar om sessions-varibeln är satt vilket betyder att en användare är inloggad.
	public function userLoggedIn(){

		if(isset($_SESSION[$this->sessionLoginData])){
			return true;
		}
		else{
			return false;
		}
	}

	// Hämtar vilken användare som är inloggad.
	public function getLoggedInUser(){
		return $_SESSION[$this->sessionLoginData];
	}

	// Kontrollerar att inmatat användarnamn och lösenord stämmer vid eventuell inloggning.
	public function checkLogin($clientUsername, $clientPassword){

		if($clientUsername === $this->username && ($clientPassword === $this->password || $clientPassword === md5($this->password)) ){

			// Sparar ner den inloggad användaren till sessionen.
			$_SESSION[$this->sessionLoginData] = $clientUsername;		
			return true;
		}
		else{
			throw new \Exception("Felaktigt användarnamn och/eller lösenord!");
		}
	}

	// Unsettar sessionsvariabeln och dödar sessionen vid eventuell utloggning.
	public function logOut(){
		unset($_SESSION[$this->sessionLoginData]);
		session_destroy();
	}
}