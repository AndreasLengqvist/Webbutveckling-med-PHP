<?php

namespace controller;

require_once("src/model/QuizRepository.php");
require_once("src/model/QuestionRepository.php");
require_once("src/model/AdressRepository.php");
require_once("src/model/CreateSession.php");
require_once('src/view/QuestionView.php');


/**
* Kontroller för CRUD av frågor.
*/
class QuestionController{

	private $createSession;			// Instans av CreateSession();
	private $quizRepository;		// Instans av QuizRepository();
	private $questionRepository;	// Instans av QuestionRepository();
	private $adressRepository;		// Instans av AdressRepository();
	private $questionView;			// Instans av QuestionView();

	private $quizId;
	private $questions;


/**
  * Instansiserar alla nödvändiga modeller och vyer.
  * Hämtar även ut nödvändig data för att minska anrop i senare funktioner.
  */
	public function __construct(){
		$this->createSession = new \model\CreateSession();
		$this->quizRepository = new \model\QuizRepository();
		$this->questionRepository = new \model\QuestionRepository();
		$this->adressRepository = new \model\AdressRepository();

		$this->quizId = $this->createSession->getCreateSession();

		$this->questionView = new \view\QuestionView($this->createSession, $this->quizRepository, $this->questionRepository, $this->quizId);
	}

/**
  * CRUD-funktion.
  */
	public function doQuestion(){


		// Redirects för olika URL-tillstånd.
			if (!$this->createSession->createSessionIsset()) {
				\view\NavigationView::RedirectHome();
			}

			if($this->questionView->finished()){
				\view\NavigationView::RedirectToPlayerView();
			}


		// CREATE.
			$questionToCreate = $this->questionView->getQuestionToCreate();
			if($questionToCreate and $questionToCreate->isValid()){
				$this->questionRepository->addQuestion($questionToCreate);
				\view\NavigationView::RedirectToCreateQuestions();
			}


		// READ
			$questionsObj = $this->questionRepository->getQuestionsById($this->quizId);
			$this->questions = $questionsObj->getQuestions();


		// UPDATE.
			$questionToUpdate = $this->questionView->getQuestionToUpdate();
			if($questionToUpdate and $questionToUpdate->isValid()){
				$this->questionRepository->updateQuestion($questionToUpdate);
				\view\NavigationView::RedirectToCreateQuestions();
			}


		// DELETE.
			if($this->questionView->deleteQuestion()){
				$questionToDelete = $this->questionView->getQuestionToDelete();
				$this->questionRepository->deleteQuestion($questionToDelete);
				\view\NavigationView::RedirectToCreateQuestions();
			}


		// RESTART - omstart av hela applikationen, tar bort all sparad data. Bryta ut?
			if($this->questionView->restart()){

				$adresses = $this->adressRepository->getAdressesById($this->quizId);

				// Om det finns frågor sparade i databasen.
					if ($this->questions) {
						foreach ($this->questions as $question) {
							$this->questionRepository->deleteQuestion($question);
						}
					}

				// Om det finns mailadresser skapade i databasen.
					if ($adresses) {
						$returnedAdresses = $adresses->getAdresses();
						foreach ($returnedAdresses as $adress) {
							$this->adressRepository->deleteAdress($adress);
						}
					}

				$this->quizRepository->deleteQuiz($this->quizId);
				$this->createSession->unSetCreateSession();
				\view\NavigationView::RedirectHome();
			}
			

		// Utdata.
			return $this->questionView->show($this->questions);
	}
}