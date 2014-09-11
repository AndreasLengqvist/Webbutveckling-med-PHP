<?php

session_start();

require_once("../common/HTMLView.php");
require_once("src/controller/LoginController.php");
require_once("src/model/LoginModel.php");
require_once("src/view/LoginView.php");

// Sätter headern till att tillåta UTF-8 (å, ä , ö). 
header('Content-Type: text/html; charset=utf-8');


$doC = new LoginController();
$htmlBody = $doC->doControll();

$view = new  HTMLView();
$view->echoHTML($htmlBody);