<?php

session_start();

require_once("common/HTMLView.php");
require_once("src/controller/NavigationController.php");

$output = new  HTMLView();
$navigation = new \controller\NavigationController();

	$htmlBody = $navigation->doNavigation();

$output->echoHTML($htmlBody);