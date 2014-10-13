<?php

namespace model;


class Quiz{

	private $title;
	private $quizId;



	// Sätter titeln och slumpar fram ett unikt ID för quizet.
	public function __construct($quizId = NULL, $title){
		$this->title = $title;
		$this->quizId = ($quizId == NULL) ? sha1(uniqid($this->title, true)) : $quizId;
	}


	public function getTitle(){
		return $this->title;
	}


	public function getQuizId(){
		return $this->quizId;
	}


	public function isValid(){
		return isset($this->title) and isset($this->quizId);
	}
}