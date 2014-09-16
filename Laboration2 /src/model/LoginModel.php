<?php


class LoginModel{
	private $sessionLoginData = "LoginModel::LoggedInUserName";
	private $username = "user";
	private $password = "pass";

	public function __construct(){


	}

	public function userLoggedIn(){
		// sessionsskit om att en användare är inloggad ska ligga här jao.
		if(isset($_SESSION[$this->sessionLoginData])){
			return true;
		}
		else{
			return false;
		}

	}


	public function checkLogin($clientUsername, $clientPassword){

		if($clientUsername === $this->username && $clientPassword === $this->password ){

			// Sparar ner det inloggade användarnamnet till sessionen.
			$_SESSION[$this->sessionLoginData] = $clientUsername;		
			return true;
		}
		else{
			throw new \Exception("Felaktigt användarnamn och/eller lösenord!");
		}
	}
}