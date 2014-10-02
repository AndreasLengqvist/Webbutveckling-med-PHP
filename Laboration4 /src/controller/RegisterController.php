<?php


require_once("src/model/RegisterModel.php");
require_once("src/view/RegisterView.php");
require_once("src/view/DateTimeView.php");


class RegisterController{

	private $loginview;
	private $userview;
	private $model;
	private $registerview;
	private $controller;

	public function __construct(){

		// Struktur för att få till MVC.
		$this->model = new RegisterModel();
		$this->registerview = new RegisterView($this->model);
		$this->datetimeview = new DateTimeView();
		$this->controller = new LoginController();
	}

	public function doControll(){

	// Hanterar indata.

		// Om användaren tryckt på Registera.
		if($this->registerview->didUserPressRegister()){
			// Hämtar validerat användarnamn och lösenord.
				$clientUsername = $this->registerview->getUsername();			
				$clientPassword = $this->registerview->getPassword();
				
			try{
				
			} catch (Exception $e) {
				// exception
			}
		}

	// Generar utdata.
		return $this->registerview->showRegister() . $this->datetimeview->show();
;
	}
}