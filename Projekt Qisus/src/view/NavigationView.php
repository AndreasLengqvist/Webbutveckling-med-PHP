<?php

namespace view;


class NavigationView{

	public static $action = 'action';
	public static $game = 'game';
	public static $player = 'player';

	public static $actionHome = 'start';
	public static $actionAddTitle = 'skapa';
	public static $actionAddQuestions = 'skapa/frågor';
	public static $actionAddPlayers = 'skapa/spelare';
	public static $actionMailQuiz = 'skicka';
	public static $actionPlay = 'spela';



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
		header('Location:  /' . \Config::$ROOT_PATH . '/');
	}


	public static function RedirectToQuestionView() {
		header('Location:  /' . \Config::$ROOT_PATH . '/?' . self::$action.'='.self::$actionAddQuestions);
	}


	public static function RedirectToPlayerView() {
		header('Location:  /' . \Config::$ROOT_PATH . '/?' . self::$action.'='.self::$actionAddPlayers);
	}


	public static function RedirectToMailView() {
		header('Location:  /' . \Config::$ROOT_PATH . '/?' . self::$action.'='.self::$actionMailQuiz);
	}


	public static function RedirectToGameView() {
		header('Location:  /' . \Config::$ROOT_PATH . '/?' . self::$action.'='.self::$actionPlay);
	}

	public static function showStart(){
		$ret = "
					<h1 id='tiny_header'>qisus.</h1>
					<h1 id='big_header'>qisus.</h1>
					<div id='center_wrap'>
						<h2 id='home_h2'>Skapa quiz!</h2>
						<h3 id='arrow'>↓</h3>
						<a id='navbutton' href='?" . self::$action . '=' . self::$actionAddTitle . "'>Start</a>
						
						<div id='info_div'>
							<p class='info'>Välkommen till qisus.</p>
							<p class='info'>Verktyget som gör det lekande lätt att skapa enkla quiz för just dina behov!</p>
						</div>
					</div>
				";
				
		return $ret;
	}
}