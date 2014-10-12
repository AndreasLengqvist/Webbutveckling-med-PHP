<?php

namespace model;

require_once("QuizRepository.php");


class Mail{

	private $quizId;
	private $message;



	// Sätter frågan och svaret.
	public function __construct($quizId, $message){
		$this->quizId = $quizId;
		$this->message = $message ;
	}


	public function getQuizId(){
		return $this->quizId;
	}


	public function getAdress(){
		return $this->message;
	}

	public function isValid(){
		return isset($this->quizId) and isset($this->adress) and isset($this->adressId);
	}
}