<?php

namespace model;


class PlaySession{


	private $gameSession = "gameSession";
	private $playerSession = "playerSession";



	public function playSessionsIsset(){
		return isset($_SESSION[$this->gameSession]) and isset($_SESSION[$this->playerSession]);
	}


	public function setPlaySessions($gameId, $playerId){
		$_SESSION[$this->gameSession] = $gameId;		
		$_SESSION[$this->playerSession] = $playerId;		
	}


	public function getPlayerSession(){
		return $_SESSION[$this->playerSession];
	}

	public function getGameSession(){
		return $_SESSION[$this->gameSession];
	}


	public function unSetPlaySessions(){
		unset($_SESSION[$this->gameSession]);
		unset($_SESSION[$this->playerSession]);
	}
}