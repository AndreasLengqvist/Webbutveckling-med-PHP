<?php


class LoginModel{
	private $sessionUserName = "LoginModel::LoginUserName";
	private $username = "user";
	private $password = "pass";

	public function __construct(){
		if(isset($_SESSION[$this->sessionUserName]) == false){
			//return $_SESSION[$this->sessionUserName] = "";
		}
		else{
			//return $_SESSION[$this->sessionUserName];
		}

	}


	public function errorHandling($username, $password){


		if($username == null){
			return "<p>Användarnamn saknas!</p>";
		}

		if($password == null){
			return "<p>Lösenord saknas!</p>";
		}
		if ($username === $this->username && $password === $this->username) {
			return "<p>Inloggningen lyckades!</p>";
		}
		else{
			return "<p>Felaktigt användarnamn och/eller lösenord!</p>";
		}
	}	


	public function checkLogin($clientUsername, $clientPassword){

		if($clientUsername === $this->username &&  $clientPassword === $this->password ){
			
			return true;
		}
		else{

			return false;
		}
	}
}