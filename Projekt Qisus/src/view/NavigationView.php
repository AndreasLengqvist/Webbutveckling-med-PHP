<?php

namespace view;


class NavigationView{
	
	// Statiska medlemsvariabler för att motverka strängberoenden.
	public static $action = 'action';
	public static $game = 'game';
	public static $player = 'player';

	// Statiska medlemsvariabler för att motverka strängberoenden.
	public static $actionHome = 'start';
	public static $actionCreate = 'create';
	public static $actionCreateTitle = 'create/title';
	public static $actionCreateCreator = 'create/owner';
	public static $actionCreateQuestions = 'create/questions';
	public static $actionCreatePlayers = 'create/players';
	public static $actionSend = 'send';
	public static $actionError = 'error';
	public static $actionPlay = 'play';
	public static $actionPlaying = 'playing';



	// Kontrollerar vart användaren befinner sig genom att hämta aktuell action i URL:n.
	public static function getUrlAction(){
		if (isset($_GET[self::$action])) {
			return $_GET[self::$action];
		}
		return self::$actionHome;
	}


	public static function getUrlGame(){
		if (isset($_GET[self::$game])) {
			return $_GET[self::$game];
		}
	}


	public static function getUrlPlayer(){
		if (isset($_GET[self::$player])) {
			return $_GET[self::$player];
		}
	}


	public static function RedirectHome() {
		header('Location:  /' . \Config::ROOT_PATH . '');
	}
	

	public static function RedirectToErrorPage() {
		header('Location:  /' . \Config::ROOT_PATH . '/?' . self::$action.'='.self::$actionError);
	}
	

	public static function RedirectToCreateTitle() {
		header('Location:  /' . \Config::ROOT_PATH . '/?' . self::$action.'='.self::$actionCreateTitle);
	}


	public static function RedirectToCreateCreator() {
		header('Location:  /' . \Config::ROOT_PATH . '/?' . self::$action.'='.self::$actionCreateCreator);
	}


	public static function RedirectToQuestionView() {
		header('Location:  /' . \Config::ROOT_PATH . '/?' . self::$action.'='.self::$actionCreateQuestions);
	}


	public static function RedirectToAdressView() {
		header('Location:  /' . \Config::ROOT_PATH . '/?' . self::$action.'='.self::$actionCreatePlayers);
	}


	public static function RedirectToSend() {
		header('Location:  /' . \Config::ROOT_PATH . '/?' . self::$action.'='.self::$actionSend);
	}


	public static function RedirectToSetupView() {
		header('Location:  /' . \Config::ROOT_PATH . '/?' . self::$action.'='.self::$actionPlay);
	}


	public static function RedirectToGameView() {
		header('Location:  /' . \Config::ROOT_PATH . '/?' . self::$action.'='.self::$actionPlaying);
	}


	public static function showStart(){
		$ret = "
					<h1 id='tiny_header'>qisus.</h1>
					<h1 id='big_header'>qisus.</h1>
					<div id='center_wrap'>
						<h2 id='home_h2'>Skapa quiz!</h2>
						<h3 id='arrow'>↓</h3>
						<a id='navbutton' href='?" . self::$action . '=' . self::$actionCreateTitle . "'>Start</a>
						
						<div id='info_div'>
							<p>Välkommen till qisus.</p>
							<p>Verktyget som gör det lekande lätt att skapa enkla quiz för just dina behov!</p>
						</div>
					</div>
				";
				
		return $ret;
	}


		public static function showError(){
		$ret = "
					<h1 id='tiny_header'>qisus.</h1>
					<h1 id='big_header'>error.</h1>
					<div id='center_wrap'>
						<h2 id='home_h2'>Ett fel inträffade!</h2>						
						<div id='info_div'>
							<p>Felet har noterats.</p>
							<p>Gå tillbaka till startsidan och testa igen.</p>
						</div>
					</div>
				";
				
		return $ret;
	}
}