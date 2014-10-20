<?php

namespace model;

require_once("src/model/QuizRepository.php");
require_once("src/model/AdressRepository.php");


class Game{

	private $quiz;
	private $quizId;
	private $player;
	private $playerId;


/**
  * Kontrollerar och sätter om quizet och spelaren finns lagrad och 
  * alltså inte har spelat redan.
  *
  */
	public function __construct($quizId, $playerId){
		$this->quizRepository = new QuizRepository();
		$this->adressRepository = new AdressRepository();

		$quiz = $this->quizRepository->getTitleById($quizId);
		$player = $this->adressRepository->getAdressById($playerId);

		if ($quiz === NULL or $player === NULL) {
			throw new \Exception("Spelet kunde inte laddas.");
		}

		$this->quiz = $quiz;
		$this->player = $player;
		$this->playerId = $playerId;
		$this->quizId = $quizId;
	}


	public function getQuiz(){
		return $this->quiz;
	}


	public function getQuizId(){
		return $this->quizId;
	}


	public function getPlayer(){
		return $this->player;
	}


	public function getPlayerId(){
		return $this->playerId;
	}


	public function isValid(){
		return isset($this->quiz) and isset($this->quizId) and isset($this->player) and isset($this->playerId);
	}
}