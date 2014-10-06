<?php

namespace model;


class Question{


	private $question;
	private $answer;

	// Validerar och sätter användarnamn och lösenord.
	public function __construct($question, $answer){

		// Om både användarnamn och båda lösenorden är för korta.
        if(empty($question)){
        	throw new \Exception("Ingen fråga skriven!");
        }

		$this->question = $question;
		$this->answer = $answer;
	}

	public function getQuestion(){
		return $this->question;
	}

	public function getAnswer(){
		return $this->answer;
	}
}