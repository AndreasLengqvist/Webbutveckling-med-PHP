<?php

namespace model;

/**
* Skapar en lista(array) av Question-objekt.
*/
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