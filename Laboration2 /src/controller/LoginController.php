<?php

require_once("src/model/LoginModel.php");
require_once("src/view/LoginView.php");
require_once("src/view/UserView.php");


class LoginController{

	private $loginview;
	private $userview;
	private $model;

	public function __construct(){
		$this->model = new LoginModel();
		$this->loginview = new LoginView($this->model);
		$this->userview = new UserView($this->model);
	}

	public function doControll(){

	// Hanterar indata.

		// Om användaren tryckt på logga in.
		if($this->loginview->didUserPressLogin()){

			// Hämtar Användarnamn och Lösenord.
			$clientUsername = $this->loginview->getUsername();
			$clientPassword = $this->loginview->getPassword();

			// Gör en kontroll på om användarnamn och lösenord stämmer.
			if($this->model->checkLogin($clientUsername, $clientPassword) === true){

				// Om checkboxen för att spara inloggningsuppgifterna är ikryssad och inloggningen lyckades.
				if($this->loginview->checkboxFilled() && $this->model->checkLogin($clientUsername, $clientPassword) === true){
					
					// Spara ner användarnamn och krypterat lösenord till resp. cookie.
				}

				//Slutligen sätt sessionsvariabeln till clientanvändarnamnet.

			}
		}


	// Generar utdata.

		//Om inloggningen lyckades visa användarfönstret.
		if($this->model->userLoggedIn()){
			return $this->userview->showUser();
		}
		// Annars visa inloggningsfönstret.
		else{
			return $this->loginview->showLogin();
		}
	}
}