<?php

namespace model;

require_once("QuizRepository.php");


class Questions{

	private $questions;


	// Sätter frågan och svaret.
	public function __construct(){
		$this->questions = array();
	}


	public function getQuestions(){
		return $this->questions;
	}


	public function addQuestions(Question $question){
		array_unshift($this->questions, $question);
	}
}