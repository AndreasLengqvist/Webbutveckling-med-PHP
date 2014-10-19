<?php

namespace model;

require_once("src/model/QuizRepository.php");
require_once("src/model/AdressRepository.php");


class CreateModel{


	private $createSession = "CreateSession";
	private $titleSession = "TitleSession";



	public function createSessionIsset(){
		return isset($_SESSION[$this->createSession]);
	}

	public function titleSessionIsset(){
		return isset($_SESSION[$this->titleSession]);
	}


	public function setCreateSession($session){
		$_SESSION[$this->createSession] = $session;		
	}

	public function setTitleSession($session){
		$_SESSION[$this->titleSession] = $session;		
	}


	public function getCreateSession(){
		if ($this->createSessionIsset()) {
			return $_SESSION[$this->createSession];
		}
	}

	public function getTitleSession(){
		if ($this->titleSessionIsset()) {
			return $_SESSION[$this->titleSession];
		}
	}


	public function unSetCreateSession(){
		unset($_SESSION[$this->titleSession]);
		unset($_SESSION[$this->createSession]);
	}


	public function resetQuiz(){

		$questionRepository = new QuestionRepository();
		$adressRepository = new AdressRepository();
		$quizRepository = new QuizRepository();
		$quizId = $this->getCreateSession();

		$questionsObj = $questionRepository->getQuestionsById($quizId);
		$adressesObj = $adressRepository->getAdressesById($quizId);

		$questions = $questionsObj->getQuestions();
		$adresses = $adressesObj->getAdresses();

		// Om det finns frågor för quizet sparade i databasen.
			if ($questions) {
				foreach ($questions as $question) {
					$questionRepository->deleteQuestion($question);
				}
			}

		// Om det finns mailadresser för quizet sparade i databasen.
			if ($adresses) {
				foreach ($adresses as $adress) {
					$adressRepository->deleteAdress($adress);
				}
			}

		$quizRepository->deleteQuiz($quizId);
		$this->unSetCreateSession();
	}
}