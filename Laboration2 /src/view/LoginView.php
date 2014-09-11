<?php

require_once("src/controller/LoginController.php");


class LoginView{
	
	private $model;
	private $getusername = "username";
	private $getpassword = "password";


	public function __construct(LoginModel $model){
		$this->model = $model;
	}

	public function didUserPressLogin()	{
		if(isset($_POST["loginit"])){
			return true;
		}
		else{
			return false;
		}
	}


	public function getLoginData(){

		$LoginData = array("username" => $_POST[$this->getusername], "password" => $_POST[$this->getpassword]);

		return $LoginData;
	}


	public function showLogin(){

		$ret = 
				"
				<fieldset>
				<legend>Logga in här!</legend>
				<form action='' method='post' >
					Användarnamn: <input type='text' name='username'>
					Lösenord: <input type='text' name='password'>
					<input type='submit' value='Logga in' name='loginit'>
				</form>
				</fieldset>
				";


		return $ret;
	}

}