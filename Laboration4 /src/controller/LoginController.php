<?php

namespace controller;

require_once("src/model/LoginModel.php");
require_once("src/view/LoginView.php");
require_once("src/view/UserView.php");
require_once("src/view/RegisterView.php");
require_once("src/view/DateTimeView.php");
require_once("./common/Agent.php");

class LoginController{

	private $helpers;
	private $loginview;
	private $userview;
	private $model;

	public function __construct(){

		// Struktur för att få till MVC.
		$this->model = new \model\LoginModel();
		$this->loginview = new \view\LoginView($this->model);
		$this->userview = new \view\UserView($this->model);
		$this->datetimeview = new \view\DateTimeView();
		$this->helpers = new \Agent();
	}

	public function doControll(){

	// Hanterar indata.

	// Hämtar information som webbläsaren användaren sitter i.
	$userAgent = $this->helpers->getUserAgent();

		// Kollar ifall en registrering gjorts.
		if($this->model->checkRegistered()){
	    	$this->loginview->successfullRegister();
		}

		// Om det finns kakor lagrade och användaren inte redan är inloggad.
		if($this->loginview->userIsRemembered() and !$this->model->userLoggedIn($userAgent)){
			try {
				// Hämtar de lagrade kakorna, kontrollerar och jämför dem med sparad data.
				$this->model->checkLoginWithCookies($this->loginview->getUsernameCookie(), $this->loginview->getPasswordCookie(), $userAgent);
				$this->userview->successfullLogInWithCookiesLoad();						
			} catch (Exception $e) {
				$this->loginview->forgetRememberedUser();
				$this->loginview->showStatus($e->getMessage());
			}
		}

		// Om användaren redan är inloggad.
		if($this->userview->didUserPressLogout()){
			$this->loginview->forgetRememberedUser();
			$this->model->logOut();
			$this->loginview->successfullLogOut();
		}

		// Om användaren inte är inloggad och tryckt på Logga in.
		if($this->loginview->didUserPressLogin()){

			try {
				// Hämtar användarnamn och lösenord.
				$clientUsername = $this->loginview->getUsername();
				$clientPassword = $this->loginview->getPassword();		
					
					// Kontrollerar om användarnamn och lösenord överensstämmer med sparad data.
					$this->model->checkLogin($clientUsername, $clientPassword, $userAgent);

					// Om "Håll mig inloggad" är ikryssad, spara i cookies.
					if ($this->loginview->RememberMeIsFilled()) {
						$this->loginview->saveToCookies($clientUsername, $clientPassword);
						$this->userview->successfullLogInWithCookiesSaved();
					}
					else{
						$this->userview->successfullLogIn();						
					}

			// Felmeddelande vid eventuella fel i try-satsen.
			} catch (\Exception $e) {
				$this->loginview->setMessage($e->getMessage());
			}
		}


	// Generar utdata.

		// Om inloggningen lyckades visa användarfönstret.
		if($this->model->userLoggedIn($userAgent)){
			return $this->userview->showUser() . $this->datetimeview->show();
		}
		// Annars visa inloggningsfönstret.
		else{
			return $this->loginview->showLogin() . $this->datetimeview->show();
		}
	}
}