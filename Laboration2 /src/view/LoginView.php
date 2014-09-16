<?php

require_once("CookieStorage.php");


class LoginView{
	
	private $model;
	private $UserName;
	private $PassWord;
	private $errormessage;

	public function __construct(LoginModel $model){
		$this->model = $model;
		//$this->UserName = new CookieStorage();
		//$this->PassWord = new CookieStorage();
	}

	public function didUserPressLogin()	{
		if(isset($_POST["LoginView::login"])){
			return $_POST["LoginView::login"];
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

		if (empty($_POST["LoginView::username"])) {
			throw new \Exception("Användarnamn saknas!");
		}
		else {
			return $_POST["LoginView::username"];	
		}
	}

	// Hämtar lösenordet.
	public function getPassword(){

		if (empty($_POST["LoginView::password"])) {
			throw new \Exception("Lösenord saknas!");	
		}
		else {
			return $_POST["LoginView::password"];	
		}
	}

	// Presenterar felmeddelandet vid inloggningsfel.
	public function showError($e){
		$this->errormessage = $e;
	}


	// Presentation av utdata.
	public function showLogin(){


		$ret = "<h1>Laboration 2 - Inloggning - al223bn</h1>";

		$ret .= "<h2>Ej inloggad!</h2>";

		$ret .= 
				"
				<fieldset>
				<legend>Logga in här!</legend>";

		$ret .= "<p>$this->errormessage</p>";

		$ret .= "
				<form action='?login' method='post' >
					Användarnamn: <input type='text' name='LoginView::username'>
					Lösenord: <input type='text' name='LoginView::password'>
					<input type='submit' value='Logga in' name='LoginView::login'>
					<input type='checkbox' name='LoginView::checked'>
				</form>
				</fieldset>
				";

		return $ret;
	}

}