<?php

namespace model;

require_once("QuizRepository.php");


class Game{

	private $gameId;
	private $playerId;



	// Sätter gameId och playerId.
	public function __construct($gameId, $playerId){
		$this->quizRepository = new QuizRepository();
		if ($this->quizRepository->getTitleById($gameId) === NULL or $this->quizRepository->getAdressById($playerId) === NULL) {
			throw new \Exception();
		}
		$this->gameId = $gameId;
		$this->playerId = $playerId;
	}


	public function getGameId(){
		return $this->gameId;
	}


	public function getPlayerId(){
		return $this->playerId;
	}


	public function isValid(){
		return isset($this->gameId) and isset($this->playerId);
	}
}