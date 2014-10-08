<?php

namespace model;


class Quiz{

	private $title;
	private $quizId;



	// Sätter titeln och slumpar fram ett unikt ID för quizet.
	public function __construct($title){
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