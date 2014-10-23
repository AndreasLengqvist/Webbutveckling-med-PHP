<?php

class UserAgent{
	
	public function getUserAgent(){
		return $_SERVER['HTTP_USER_AGENT'];
	}
}