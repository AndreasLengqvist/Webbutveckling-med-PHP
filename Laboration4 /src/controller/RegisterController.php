<?php

namespace controller;

require_once("src/model/RegisterRepository.php");
require_once("src/model/User.php");
require_once("src/view/RegisterView.php");
require_once("src/view/DateTimeView.php");


class RegisterController{

	private $loginview;
	private $userview;
	private $registerrepository;
	private $registerview;

	public function __construct(){

		// Struktur för att få till MVC.
		$this->loginmodel = new \model\LoginModel();
		$this->registerrepository = new \model\RegisterRepository();
		$this->registerview = new \view\RegisterView();
		$this->datetimeview = new \view\DateTimeView();
	}

	public function doControll(){

	// Hanterar indata.

		// Om användaren tryckt på Registera.
		if($this->registerview->didUserPressRegister()){
			try{

				// Hämtar den inmatade datan.
				$registerData = new \model\User($this->registerview->getUsername(), $this->registerview->getPassword(), $this->registerview->getRepeatedPassword());
				
				// Kollar ifall användarnamnet redan existerar i databasen.
				if ($this->registerrepository->usernameExists($this->registerview->getUsername())) {
		            throw new \AlreadyExistsException("Errorcode: ", 201);
				}
				
				// Skapar ny användare med den inmatade datan.
				$this->registerrepository->create($registerData);
				$this->loginmodel->setSession("success");
				$this->registerview->backToLogin();	
			}
			// Exceptions som skickar vidare de olika felkoderna.
			catch (\TooShortException $e) {
				$this->registerview->setMessage($e->getMessage(), $e->getCode());
			}
			catch (\InvalidCharException $e) {
				$this->registerview->setMessage($e->getMessage(), $e->getCode());
			}
			catch (\NoMatchException $e) {
				$this->registerview->setMessage($e->getMessage(), $e->getCode());
			}
			catch (\AlreadyExistsException $e) {
				$this->registerview->setMessage($e->getMessage(), $e->getCode());
			}
			catch (\Exception $e) {
				$this->registerview->setMessage($e->getMessage(), $e->getCode());
			}
		}

	// Generar utdata.
		return $this->registerview->showRegister() . $this->datetimeview->show();
;
	}
}