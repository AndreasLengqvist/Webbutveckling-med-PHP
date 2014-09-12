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


	public function messageHandling($errorcode){


		if ($errorcode === 1) {
			return "<p>Inloggningen lyckades!</p>";
		}
		if ($errorcode === 2) {
			return "<p>Felaktigt användarnamn och/eller lösenord!</p>";
		}
	}	


	public function checkLogin($clientUsername, $clientPassword){

		if($clientUsername === $this->username &&  $clientPassword === $this->password ){

			// Sparar ner det inloggade användarnamnet till sessionen.
			$_SESSION[$this->sessionLoginData] = $clientUsername;		
			return true;
		}
		else{
			return false;
		}
	}
}