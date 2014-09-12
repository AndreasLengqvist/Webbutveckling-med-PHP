<?php

require_once("src/model/LoginModel.php");
require_once("src/view/LoginView.php");


class LoginController{

	private $view;
	private $model;

	public function __construct(){
		$this->model = new LoginModel();
		$this->view = new LoginView($this->model);
	}

	public function doControll(){

		$clientUsername = $this->view->getUsername();
		$clientPassword = $this->view->getPassword();

		// Hanterar indata.

		// Om användaren tryckt på logga in.
		if($this->view->didUserPressLogin()){

			// Gör en kontroll på om användarnamn och lösenord stämmer.
			$this->model->checkLogin($clientUsername, $clientPassword);

			// Om checkboxen för att spara inloggningsuppgifterna är ikryssad och inloggningen lyckades.
			if($this->view->checkboxFilled() && $this->model->checkLogin($clientUsername, $clientPassword) === true){
				// Spara ner användarnamn och krypterat lösenord till kakor.
			}
		}

		// Generar utdata.
		return $this->view->showLogin();
	}

}