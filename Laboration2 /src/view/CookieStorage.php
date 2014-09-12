<?php


class CookieStorage{
	
	public function saveUserName($Username){
		setcookie("UserName", $Username, -1);
	}


	public function savePassWord($Password){
		setcookie("UserName", $Username, -1);
	}
}