<?php



class Agent{
	
	public function getUserAgent(){
		return $_SERVER['HTTP_USER_AGENT'];
	}
}