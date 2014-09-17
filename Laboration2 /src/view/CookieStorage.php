<?php


class CookieStorage{

	private static $cookieUsername = "LoginView::Username";
	private static $cookiePassword = "LoginView::Password";

	public function saveUsernameCookie($string){
		setcookie(self::$cookieUsername, $string, strtotime('+1 minutes'));
	}

	public function savePasswordCookie($string){
		setcookie(self::$cookiePassword, $string, strtotime('+1 minutes'));
	}

	public function loadUsernameCookie(){
		if (isset($_COOKIE[self::$cookieUsername])) {
			return $_COOKIE[self::$cookieUsername];
		}
		else{
			return false;
		}
	}

	public function loadPasswordCookie(){
		if (isset($_COOKIE[self::$cookiePassword])) {
			return $_COOKIE[self::$cookiePassword];
		}
		else{
			return false;
		}	}

	public function removeUsernameCookie(){
		setcookie (self::$cookieUsername, "", time() - 3600);
	}

	public function removePasswordCookie(){
		setcookie (self::$cookiePassword, "", time() - 3600);
	}

}