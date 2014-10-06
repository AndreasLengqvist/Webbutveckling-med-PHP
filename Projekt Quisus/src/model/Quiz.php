<?php

namespace model;


class Quiz{


	private $question;
	private $answer;

	// Validerar och sätter användarnamn och lösenord.
	public function __construct($question, $answer){

		// Om både användarnamn och båda lösenorden är för korta.
        if(empty($question)){
        	throw new \Exception("Inga frågor skrivna!");
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