<?php

namespace model;

require_once("QuizRepository.php");


class Questions{

	private $questions;



	public function __construct(){
		$this->questions = array();
	}


	public function getQuestions(){
		return $this->questions;
	}


	public function addQuestions(Question $question){
		$this->questions[] = $question;
	}
}