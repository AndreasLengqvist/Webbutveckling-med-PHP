<?php

namespace model;


class Quiz{

	private $title;
	private $quizId;
	private $creator;



	public function __construct($quizId = NULL, $title, $creator){

    	if(!filter_var($creator, FILTER_VALIDATE_EMAIL)){
    		throw new \Exception("Ogiltig mailadress.");
    	}

		$this->title = $title;
		$this->creator = $creator;
		$this->quizId = ($quizId == NULL) ? sha1(uniqid($this->title, true)) : $quizId;
	}


	public function getQuizId(){
		return $this->quizId;
	}


	public function getTitle(){
		return $this->title;
	}


	public function getCreator(){
		return $this->creator;
	}


	public function isValid(){
		return isset($this->quizId) and isset($this->title) and isset($this->creator);
	}
}