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

		return $this->view->showLogin();
	
	}

}