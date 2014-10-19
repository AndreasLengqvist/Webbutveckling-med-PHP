<?php

namespace model;


class PlayModel{


	private $quizSession = "QuizSession";
	private $quizIdSession = "QuizIdSession";
	private $playerSession = "PlayerSession";

	private $answers = "Answers";				// SessionsArray.



	public function playSessionsIsset(){
		return isset($_SESSION[$this->quizSession]) and isset($_SESSION[$this->quizIdSession]) and isset($_SESSION[$this->playerSession]);
	}

	public function answerSessionIsset(){
		return isset($_SESSION[$this->answers]);
	}


	public function setPlaySessions($quiz, $quizId, $player, $playerId){
		$_SESSION[$this->quizSession] = $quiz;		
		$_SESSION[$this->quizIdSession] = $quizId;		
		$_SESSION[$this->playerSession] = $player;		
	}

	public function setAnswerSession($answers){
		$_SESSION[$this->answers] = $answers;		
	}



	public function getQuizSession(){
		return $_SESSION[$this->quizSession];
	}

	public function getQuizIdSession(){
		return $_SESSION[$this->quizIdSession];
	}

	public function getPlayerSession(){
		return $_SESSION[$this->playerSession];
	}

	public function getAnswersSession(){
		return $_SESSION[$this->answers];
	}


	public function unSetPlaySessions(){
		unset($_SESSION[$this->quizSession]);
		unset($_SESSION[$this->quizIdSession]);
		unset($_SESSION[$this->playerSession]);
		unset($_SESSION[$this->answers]);
	}
}