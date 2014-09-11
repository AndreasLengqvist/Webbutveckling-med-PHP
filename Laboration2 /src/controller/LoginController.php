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

		// Hanterar indata.
		if($this->view->didUserPressLogin()){
			$checkLogin = $this->model->checkIfUserIsOk($this->view->getLoginData());

			if($checkLogin === true){
				echo "Inloggad";
			}
			else{
				echo "Felaktigt användarnamn eller lösenord!";
			}
		}

		// Generar utdata.
		return $this->view->showLogin();
	}

}