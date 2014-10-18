<?php

namespace view;

require_once("./config.php");


class NavigationView{

	public static $action = 'action';
	public static $game = 'game';
	public static $player = 'player';

	public static $actionHome = 'start';
	public static $actionCreate = 'create';
	public static $actionCreateTitle = 'create/title';
	public static $actionCreateCreator = 'create/owner';
	public static $actionCreateQuestions = 'create/questions';
	public static $actionCreatePlayers = 'create/players';
	public static $actionSend = 'send';
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

	
	public static function RedirectToCreateTitle() {
		header('Location:  /' . \Config::ROOT_PATH . '/?' . self::$action.'='.self::$actionCreateTitle);
	}


	public static function RedirectToCreateCreator() {
		header('Location:  /' . \Config::ROOT_PATH . '/?' . self::$action.'='.self::$actionCreateCreator);
	}


	public static function RedirectToCreateQuestions() {
		header('Location:  /' . \Config::ROOT_PATH . '/?' . self::$action.'='.self::$actionCreateQuestions);
	}


	public static function RedirectToPlayerView() {
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
}