<?php

namespace model;

require_once("src/model/LoginRepository.php");

class LoginModel{

	private $loginrepository;
	private $sessionLoginData = "LoginModel::LoggedInUserName";
	private $sessionUserAgent;
	private static $username = "username";
	private static $password = "password";


	public function __construct(){
		$this->loginrepository = new \model\LoginRepository();
	}


	// Kontrollerar om sessions-varibeln är satt vilket betyder att en användare är inloggad.
	public function userLoggedIn($userAgent){

		if(isset($_SESSION[$this->sessionLoginData]) && $_SESSION[$this->sessionUserAgent] === $userAgent){
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
	public function checkLogin($clientUsername, $clientPassword, $userAgent){

		$user = $this->loginrepository->getUserByUsername($clientUsername);
		
		if(strtolower($clientUsername) === strtolower($user[self::$username]) and $this->cryptPassword($clientPassword) === $user[self::$password]){
			
			// Sparar ner den inloggad användaren till sessionen.
			$_SESSION[$this->sessionUserAgent] = $userAgent;
			$_SESSION[$this->sessionLoginData] = $user[self::$username];		
			return true;
		}
		else{
			throw new \Exception("Felaktigt användarnamn och/eller lösenord!");
		}
	}

	// Kontrollerar att inmatat användarnamn och lösenord stämmer vid eventuell inloggning + (med kakor och förfallodatumskontroll).
	public function checkLoginWithCookies($clientUsername, $clientPassword, $userAgent){
		$time = $this->loadCookieTime();

		$user = $this->loginrepository->getUserByUsername($clientUsername);
		var_dump($this->cryptPassword($clientPassword));
		if($clientPassword === $user[self::$password] and $time > time()){

			// Sparar ner den inloggad användaren till sessionen.
			$_SESSION[$this->sessionUserAgent] = $userAgent;
			$_SESSION[$this->sessionLoginData] = $clientUsername;		
			return true;
		}
		else{
			throw new \Exception("Felaktigt information i kakan!");
		}
	}

	// Hjälpfunktion för att spara till fil.
	public function saveCookieTime($value){
		file_put_contents("CookieTime", $value);
	}

	// Hjälpfunktion för att ladda från fil.
	public function loadCookieTime(){
		return file_get_contents("CookieTime");
	}

	// Unsettar sessionsvariabeln och dödar sessionen vid eventuell utloggning.
	public function logOut(){
		unset($_SESSION[$this->sessionLoginData]);
		session_destroy();
	}

	public function checkRegistered(){
		return isset($_SESSION['session']);
	}

	public function setSession($input){
		$_SESSION['session'] = $input;
	}

	public function unSetSession(){
		unset($_SESSION['session']);
	}

	public function cryptPassword($password){
		$salt = "al321";
		return sha1($salt . $password);
	}
}