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

			// Gör en kontroll på om användarnamn och lösenord är inmatade.
			try {
				$clientUsername = $this->loginview->getUsername();
				$clientPassword = $this->loginview->getPassword();

				// Testar att logga in med inmatat användarnamn och lösenord.
				try { 
					$this->model->checkLogin($clientUsername, $clientPassword);

				} catch (Exception $e) {
					$this->loginview->showError($e->getMessage());
				}

			} catch (Exception $e) {
				$this->loginview->showError($e->getMessage());
			}



					//Slutligen sätt sessionsvariabeln till clientanvändarnamnet.
			}

	// Generar utdata.

		// Om inloggningen lyckades visa användarfönstret.
		if($this->model->userLoggedIn()){
			return $this->userview->showUser();
		}
		// Annars visa inloggningsfönstret.
		else{
			return $this->loginview->showLogin();
		}
	}
}