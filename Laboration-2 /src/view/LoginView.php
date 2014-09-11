<?php

require_once("src/controller/LoginController.php");


class LoginView{
	
	private $model;

	public function __construct(LoginModel $model){
		$this->model = $model;
	}

	public function showLogin(){

		$ret = 
		"
		<form>
			Användarnamn: <input type='text' name='username'>
			Lösenord: <input type='text' name='password'>
		  	<input type='submit' value='Logga in'>
		</form>

		";

		return $ret;
	}
}