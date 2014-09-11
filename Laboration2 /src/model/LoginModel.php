<?php


class LoginModel{
	private $sessionlocation = "LoginModel::LoginData";
	private $username = "user";
	private $password = "pass";


	public function __construct(){
		if(isset($_SESSION[$this->sessionlocation]) == false){
			//$SESSION[$this->sessionlocation] == 0;
		}
	}

	public function checkIfUserIsOk($LoginData){

		if($LoginData["username"] === $this->username &&  $LoginData["password"] === $this->password ){
			
			return true;
		}
		else{
			return false;
		}
	}
}