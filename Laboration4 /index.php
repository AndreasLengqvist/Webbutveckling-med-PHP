<?php

session_start();

require_once("common/HTMLView.php");
require_once("src/controller/LoginController.php");
require_once("src/controller/RegisterController.php");
require_once("src/model/LoginModel.php");
require_once("src/view/LoginView.php");

$output = new  HTMLView();
$loginController = new \controller\LoginController();
$registerController = new \controller\RegisterController();
$loginmodel = new \model\LoginModel();
$loginview = new \view\LoginView($loginmodel);


// Kollar ifall användaren tryck på "Registrera ny användare".
if($loginview->registerClick() === TRUE){
	$htmlBody = $registerController->doControll();
}
else{
	$htmlBody = $loginController->doControll();
}

$output->echoHTML($htmlBody);