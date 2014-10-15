<?php

namespace model;


class PlaySession{


	private $gameSession = "gameSession";
	private $playerSession = "playerSession";
	private $userAgent = "userAgent";
	private $answers = "answers";



	public function playSessionsIsset(){
		return isset($_SESSION[$this->gameSession]) and isset($_SESSION[$this->playerSession]) and isset($_SESSION[$this->userAgent]);
	}

	public function answerSessionIsset(){
		return isset($_SESSION[$this->answers]);
	}


	public function checkPlayerAgent($playerAgent){
		if ($_SESSION[$this->userAgent] === $playerAgent){
			return true;
		}
	}


	public function setPlaySessions($gameId, $playerId, $userAgent){
		$_SESSION[$this->gameSession] = $gameId;		
		$_SESSION[$this->playerSession] = $playerId;		
		$_SESSION[$this->userAgent] = $userAgent;		
	}

	public function setAnswerSession($answers){
		$_SESSION[$this->answers] = $answers;		
	}


	public function getPlayerSession(){
		return $_SESSION[$this->playerSession];
	}


	public function getGameSession(){
		return $_SESSION[$this->gameSession];
	}

	public function getAnswersSession(){
		return $_SESSION[$this->answers];
	}


	public function unSetPlaySessions(){
		unset($_SESSION[$this->gameSession]);
		unset($_SESSION[$this->playerSession]);
		unset($_SESSION[$this->userAgent]);
	}
}