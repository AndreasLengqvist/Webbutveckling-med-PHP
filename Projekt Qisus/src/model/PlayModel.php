<?php

namespace model;

require_once("src/model/AdressRepository.php");
require_once("src/model/CreateModel.php");


class PlayModel{

	// Sessionsvariabler.
	private $quizSession = "QuizSession";
	private $quizIdSession = "QuizIdSession";
	private $playerSession = "PlayerSession";
	private $playerIdSession = "PlayerIdSession";

	// Sessionsarray.
	private $answers = "Answers";



	public function playSessionsIsset(){
		return isset($_SESSION[$this->quizSession]) and isset($_SESSION[$this->quizIdSession]) and isset($_SESSION[$this->playerSession]) and isset($_SESSION[$this->playerIdSession]);
	}


	public function answerSessionIsset(){
		return isset($_SESSION[$this->answers]);
	}


	public function setPlaySessions($quiz, $quizId, $player, $playerId){
		$_SESSION[$this->quizSession] = $quiz;		
		$_SESSION[$this->quizIdSession] = $quizId;		
		$_SESSION[$this->playerSession] = $player;		
		$_SESSION[$this->playerIdSession] = $playerId;		
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


	public function getPlayerIdSession(){
		return $_SESSION[$this->playerIdSession];
	}


	public function getAnswersSession(){
		return $_SESSION[$this->answers];
	}


	public function unSetPlaySessions(){
		unset($_SESSION[$this->quizSession]);
		unset($_SESSION[$this->quizIdSession]);
		unset($_SESSION[$this->playerSession]);
		unset($_SESSION[$this->playerIdSession]);
		unset($_SESSION[$this->answers]);
	}


/**
  * Funktion som gör det möjligt att checka av om quizet är färdigspelat. Genom att
  * kontrollera om adresser finns kvar efter att den spelade adressen tagits bort.
  * I sådana fall skapas en ny modell som anropar dess ResetQuiz-Funktion för borttagning
  * av hela quizet och dess frågor för att göra plats i databasen.
  *
  */
	public function checkQuizStatus(){

		$adressRepository = new AdressRepository();
		$quizId = $this->getQuizIdSession();

		$adressRepository->deleteAdress(new\model\Adress($quizId, $this->getPlayerSession(), $this->getPlayerIdSession()));
		
		$adressesObj = $adressRepository->getAdressesById($quizId);
		$adresses = $adressesObj->getAdresses();

		if (empty($adresses)) {
			$model = new CreateModel();
			$model->setCreateSession($quizId);
			$model->resetQuiz();
		}
	}
}