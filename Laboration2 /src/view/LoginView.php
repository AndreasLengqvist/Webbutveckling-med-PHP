<?php

require_once("CookieStorage.php");


class LoginView{
	
	private $model;
	private $UserName;
	private $PassWord;

	public function __construct(LoginModel $model){
		$this->model = $model;
		//$this->UserName = new CookieStorage();
		//$this->PassWord = new CookieStorage();
	}

	public function didUserPressLogin()	{
		if(isset($_POST["LoginView::login"])){
			return true;
		}
		else{
			return false;
		}
	}


	public function checkboxFilled(){
		if(isset($_POST["LoginView::checked"])){
			return true;
		}
	}

	// Hämtar Användarnamnet.
	public function getUsername(){

		if(isset($_POST["LoginView::username"])){
			return $_POST["LoginView::username"];
		}
		else{
			return false;
		}
	}


	public function getPassword(){

		if(isset($_POST["LoginView::password"])){
			return $_POST["LoginView::password"];
		}
		else{
			return false;
		}
	}


	public function showLogin(){

		// (Extern validering i LoginModel) Om användaren tryckt på "Logga in" så visas felmeddelande, annars inget.
		if($this->didUserPressLogin()){
			//$errormessage = $this->model->errorHandling();
		}
		else{

			$errormessage = null;
		}

		$ret = "<h1>Laboration 2 - Inloggning - al223bn</h1>";

		// Så länge användaren inte lyckats logga in korrekt visas "Ej inloggad!".
		if($this->model->checkLogin($this->getUsername(), $this->getPassword()) === false){

			$ret .= "<h2>Ej inloggad!</h2>";

		}

		// Så länge användaren inte lyckats logga in korrekt visas inloggningsformuläret.
		if($this->model->checkLogin($this->getUsername(), $this->getPassword()) === false){
		$ret .= 
				"
				<fieldset>
				<legend>Logga in här!</legend>


				";
		$ret .= "
				<form action='?login' method='post' >
					Användarnamn: <input type='text' name='LoginView::username'>
					Lösenord: <input type='text' name='LoginView::password'>
					<input type='submit' value='Logga in' name='LoginView::login'>
					<input type='checkbox' name='LoginView::checked'>
				</form>
				</fieldset>
				";
		}

		return $ret;
	}

}