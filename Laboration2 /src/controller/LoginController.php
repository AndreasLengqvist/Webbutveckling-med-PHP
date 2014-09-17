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

		// Om användaren redan är inloggad.
		if($this->model->userLoggedIn()){
			if($this->userview->didUserPressLogout()){
				$this->model->logOut();
				$this->loginview->removeCookies();
				$this->loginview->successfullLogOut();
			}
		}

		// Om det finns kakor lagrade och användaren inte redan är inloggad.
		if($this->loginview->userIsRemembered() and $this->model->userLoggedIn() === false){
			echo"adadsdsa";
			try {
				// Hämtar de lagrade kakorna, kontrollerar och jämför dem med sparad data.
				$this->model->checkLogin($this->loginview->getUsernameCookie(), $this->loginview->getPasswordCookie());
				$this->userview->successfullLogInWithCookiesLoad();						
			} catch (Exception $e) {
				$this->loginview->showStatus($e->getMessage());
			}
		}

			// Om användaren tryckt på logga in.
			if($this->loginview->didUserPressLogin()){

				try {
					// Hämtar användarnamn och lösenord.
					$clientUsername = $this->loginview->getUsername();
					$clientPassword = $this->loginview->getPassword();		
						
						// Kontrollerar om användarnamn och lösenord överensstämmer med sparad data.
						$this->model->checkLogin($clientUsername, $clientPassword);

						// Om "Håll mig inloggad" är ikryssad, spara i cookies.
						if ($this->loginview->RememberMeIsFilled()) {
							$this->loginview->saveToCookies($clientUsername, $clientPassword);
							$this->userview->successfullLogInWithCookiesSaved();
						}	
						else{
							$this->userview->successfullLogIn();						
						}

				} catch (Exception $e) {
					$this->loginview->showStatus($e->getMessage());
				}
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