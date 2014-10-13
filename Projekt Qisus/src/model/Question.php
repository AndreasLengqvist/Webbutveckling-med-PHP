<?php

namespace model;

require_once("QuizRepository.php");


class Question{

	private $quizId;
	private $question;
	private $answer;
	private $questionId;



	// Sätter frågan och svaret och slumpar fram ett unikt ID för frågan.
	public function __construct($quizId, $question, $answer, $questionId = NULL){
		$this->quizId = $quizId;
		$this->question = $question;
		$this->answer = $answer;
		$this->questionId = ($questionId == NULL) ? sha1(uniqid($this->quizId, true)) : $questionId;
	}


	public function getQuizId(){
		return $this->quizId;
	}


	public function getQuestionId(){
		return $this->questionId;
	}


	public function getQuestion(){
		return $this->question;
	}


	public function getAnswer(){
		return $this->answer;
	}


	public function isValid(){
		return isset($this->quizId) and isset($this->questionId) and isset($this->question) and isset($this->answer);
	}
}