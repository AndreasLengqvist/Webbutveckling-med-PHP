<?php

namespace model;

require_once("src/model/QuizRepository.php");
require_once("src/model/QuestionRepository.php");
require_once("src/model/AdressRepository.php");


/**
  * Modell för alla GET, SET, ISSET, UNSET SESSIONS-variabler.
  * Har även hand om CREATE, CHECK och RESET av Quiz.
  */
class QuizModel{

	// Sessionsvariabler.
	private $createSession = "CreateSession";
	private $titleSession = "TitleSession";
	private $quizSession = "QuizSession";
	private $quizIdSession = "QuizIdSession";
	private $playerSession = "PlayerSession";
	private $playerIdSession = "PlayerIdSession";

	// Sessionsarray.
	private $answers = "Answers";

	private $quizRepository;		// Instans av QuizRepository().
	private $adressRepository;		// Instans av AdressRepository().
	private $questionRepository;	// Instans av QuestionRepository().


	public function __construct(){
		$this->quizRepository = new QuizRepository();
		$this->adressRepository = new AdressRepository();
		$this->questionRepository = new QuestionRepository();


	}

/**
  * ISSETTERS.
  */
	public function createSessionIsset(){
		return isset($_SESSION[$this->createSession]);
	}

	public function titleSessionIsset(){
		return isset($_SESSION[$this->titleSession]);
	}

	public function playSessionsIsset(){
		return isset($_SESSION[$this->quizSession]) and isset($_SESSION[$this->quizIdSession]) and isset($_SESSION[$this->playerSession]) and isset($_SESSION[$this->playerIdSession]);
	}

	public function answerSessionIsset(){
		return isset($_SESSION[$this->answers]);
	}


/**
  * SETTERS.
  */
	public function setCreateSession($session){
		$_SESSION[$this->createSession] = $session;		
	}

	public function setTitleSession($session){
		$_SESSION[$this->titleSession] = $session;		
	}

	public function setPlaySessions($quiz, $quizId, $player, $playerId){
		$_SESSION[$this->quizSession] = $quiz;		
		$_SESSION[$this->quizIdSession] = $quizId;		
		$_SESSION[$this->playerSession] = $player;		
		$_SESSION[$this->playerIdSession] = $playerId;		
	}


	public function setAnswerSession($answers){
		$_SESSION[$this->answers] = $answers;		
	}



/**
  * GETTERS.
  */
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

	public function getQuizSession(){
		return $_SESSION[$this->quizSession];
	}


	public function getQuizIdSession(){
		return $_SESSION[$this->quizIdSession];
	}


	public function getPlayerSession(){
		return $_SESSION[$this->playerSession];
	}


	public function getPlayerIdSession(){
		return $_SESSION[$this->playerIdSession];
	}


	public function getAnswersSession(){
		return $_SESSION[$this->answers];
	}



/**
  * UNSETTERS.
  */
	public function unSetCreateSession(){
		unset($_SESSION[$this->titleSession]);
		unset($_SESSION[$this->createSession]);
	}

	public function unSetPlaySessions(){
		unset($_SESSION[$this->quizSession]);
		unset($_SESSION[$this->quizIdSession]);
		unset($_SESSION[$this->playerSession]);
		unset($_SESSION[$this->playerIdSession]);
		unset($_SESSION[$this->answers]);
	}



/**
  * Funktion för att skapa ett quiz. Anropas från CreateController
  * med det aktuella Quiz-objektet som in-parameter.
  *
  */
	public function createQuiz(Quiz $quiz){
		$this->quizRepository->addQuiz($quiz);
		$this->setCreateSession($quiz->getQuizId());
	}


/**
  * Funktion som gör det möjligt att checka av om quizet är färdigspelat. Genom att
  * kontrollera om adresser finns kvar efter att den spelade adressen tagits bort.
  * I sådana fall anropas ResetQuiz för borttagning
  * av hela quizet och dess frågor för att göra plats i databasen. (se. GameController)
  *
  */
	public function checkQuizStatus(){

		$quizId = $this->getQuizIdSession();

		$this->adressRepository->deleteAdress(new\model\Adress($quizId, $this->getPlayerSession(), $this->getPlayerIdSession()));
		
		$adressesObj = $this->adressRepository->getAdressesById($quizId);
		$adresses = $adressesObj->getAdresses();

		// Om det finns adresser kvar för Quizet.
		if (empty($adresses)) {
			$this->setCreateSession($quizId);
			$this->resetQuiz();
		}
		$this->unSetPlaySessions();
	}


/**
  * Funktion för att resetta ett quiz (alltså ta bort alla frågor, adresser som hör 
  * till quizet och quizet) om det finns några lagrade. (se. QuestionController)
  * Används även om ett quiz är färdigspelat. (se. GameController)
  *
  */
	public function resetQuiz(){

		$quizId = $this->getCreateSession();

		$questionsObj = $this->questionRepository->getQuestionsById($quizId);
		$adressesObj = $this->adressRepository->getAdressesById($quizId);

		$questions = $questionsObj->getQuestions();
		$adresses = $adressesObj->getAdresses();

		// Om det finns frågor för quizet sparade i databasen.
			if ($questions) {
				foreach ($questions as $question) {
					$this->questionRepository->deleteQuestion($question);
				}
			}

		// Om det finns mailadresser för quizet sparade i databasen.
			if ($adresses) {
				foreach ($adresses as $adress) {
					$this->adressRepository->deleteAdress($adress);
				}
			}

		$this->quizRepository->deleteQuiz($quizId);
		$this->unSetCreateSession();
	}
}