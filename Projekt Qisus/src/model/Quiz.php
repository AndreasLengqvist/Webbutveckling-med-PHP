<?php

namespace model;

require_once("QuizRepository.php");


class Quiz{

	private $title;
	private $quizId;



	// Sätter titeln och slumpar fram ett unikt ID för quizet.
	public function __construct($title){

		$quizRepository = new QuizRepository();

		if($quizRepository->quizExists($title)){
			throw new \Exception("Aj då! Det här quizet fanns visst redan! :O");
		}

		$this->title = $title;
		$this->quizId = sha1(uniqid($this->title, true));
	}


	public function getTitle(){
		return $this->title;
	}


	public function getQuizId(){
		return $this->quizId;
	}
}