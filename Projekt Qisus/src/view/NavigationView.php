<?php

namespace view;


class NavigationView{

	public static $action = 'action';

	public static $actionHome = 'start';
	public static $actionCreate = 'skapa';



	// Kontrollerar vart användaren befinner sig genom att hämta aktuell action i URL:n.
	public static function getUrlAction(){
		if (isset($_GET[self::$action])) {
			return $_GET[self::$action];
		}
		return self::$actionHome;
	}


	public static function showStart(){
		$ret = "
				<h1>qisus.</h1>
					<div id='center_wrap'>
						<a id='navbutton' href='?".self::$action."=".self::$actionCreate."'>Skapa!</a>
					</div>
				";

		return $ret;
	}
}