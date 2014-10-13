<?php

namespace model;

require_once("QuizRepository.php");


class Adress{

	private $quizId;
	private $adress;
	private $adressId;



	// Sätter adressen och slumpar fram ett unikt id för adressen.
	public function __construct($quizId, $adress, $adressId = NULL){
		$this->quizId = $quizId;
		$this->adress = $adress;
		$this->adressId = ($adressId == NULL) ? sha1(uniqid($this->adress, true)) : $adressId;
	}


	public function getQuizId(){
		return $this->quizId;
	}


	public function getAdress(){
		return $this->adress;
	}


	public function getAdressId(){
		return $this->adressId;
	}


	public function isValid(){
		return isset($this->quizId) and isset($this->adress) and isset($this->adressId);
	}
}