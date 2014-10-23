<?php

namespace view;


class NavigationView{

	const action = 'action';
	const member = 'medlem';

	const actionShowCompact = 'visa/kompakt';
	const actionShowDetailed = 'visa/detaljerad';
	const actionShowMember = 'visa/medlem';
	const actionCreateMember = 'skapa/medlem';
	const actionEditMember = 'editera/medlem';
	const actionCreateBoat = 'skapa/båt';
	const actionEditBoat = 'editera/båt';



	// Kontrollerar vart användaren befinner sig genom att hämta aktuell action i URL:n.
	public static function getUrlAction(){
		if (isset($_GET[self::action])) {
			return $_GET[self::action];
		}
		return self::actionShowCompact;
	}


	public static function RedirectToHome() {
		header('Location:  /' . \Config::$ROOT_PATH . '');
	}


	public static function RedirectToShowMember() {
		header('Location:  /' . \Config::$ROOT_PATH . '/?' . self::action.'='.self::actionShowMember);
	}

}