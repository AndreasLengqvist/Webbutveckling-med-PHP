<?php

namespace view;

require_once("src/model/Session.php");


class NavigationView{

	public static $action = 'action';
	public static $urlUnique = 'quiz';

	public static $actionHome = 'start';
	public static $actionAddTitle = 'skapa';
	public static $actionAddQuestions = 'skapa/frågor';
	public static $actionAddPlayers = 'skapa/spelare';


	// Kontrollerar vart användaren befinner sig genom att hämta aktuell action i URL:n.
	public static function getUrlAction($session){

		if (isset($_GET[self::$action])) {

			return $_GET[self::$action];
		}
		return self::$actionHome;
	}

	public static function RedirectHome() {
		header('Location:  /' . \Config::$ROOT_PATH . '/');
	}


	public static function RedirectToQuestionView() {
		header('Location:  /' . \Config::$ROOT_PATH . '/?' . self::$action.'='.self::$actionAddQuestions);
	}


	public static function RedirectToMailView() {
		header('Location:  /' . \Config::$ROOT_PATH . '/?' . self::$action.'='.self::$actionAddPlayers);
	}


	public static function showStart(){
		$ret = "
				<h1>qisus.</h1>
					<div id='center_wrap'>
						<h2 id='welcome'>Skapa quiz!</h2>
						<h3 id='arrow'>↓</h3>
						<a id='navbutton' href='?".self::$action.'='.self::$actionAddTitle."'>Start</a>
					</div>
				";

		return $ret;
	}
}