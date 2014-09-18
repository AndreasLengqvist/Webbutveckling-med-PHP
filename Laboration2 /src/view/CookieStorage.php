<?php


class CookieStorage{

	// Sparar kakan.
	public function saveCookie($name, $string){
		setcookie($name, $string, strtotime('+1 minutes'));
	}

	// Laddar kakan.
	public function loadCookie($name){
		if (isset($_COOKIE[$name])) {
			return $_COOKIE[$name];
		}
		else{
			return false;
		}
	}

	// Tar bort kakan.
	public function removeCookie($name){
		setcookie ($name, "", time() - 3600);
	}

}