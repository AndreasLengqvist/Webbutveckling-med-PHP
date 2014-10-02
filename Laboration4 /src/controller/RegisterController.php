<?php


require_once("src/model/LoginModel.php");
require_once("src/view/RegisterView.php");
require_once("./common/Helpers.php");


class RegisterController{

	private $loginview;
	private $userview;
	private $model;
	private $registerview;
	private $controller;

	public function __construct(){

		// Struktur för att få till MVC.
		$this->model = new RegisterModel();
		$this->loginview = new LoginView($this->model);
		$this->registerview = new RegisterView($this->model);
		$this->controller = new LoginController();
	}

	public function doControll(){

	// Hanterar indata.

	

	// Generar utdata.
		return $this->registerview->showRegister();
	}
}