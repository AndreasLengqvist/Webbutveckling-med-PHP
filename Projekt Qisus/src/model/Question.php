<?php

namespace model;

require_once("QuizRepository.php");


class Question{

	private $quizId;
	private $question;
	private $answer;



	// Sätter frågan och svaret.
	public function __construct($quizId, $question, $answer){
		$this->quizId = $quizId;
		$this->question = $question;
		$this->answer = $answer;
	}


	public function getQuizId(){
		return $this->quizId;
	}


	public function getQuestion(){
		return $this->question;
	}


	public function getAnswer(){
		return $this->answer;
	}
}