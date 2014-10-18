<?php

namespace controller;

require_once("src/model/QuizRepository.php");
require_once("src/model/CreateSession.php");
require_once('src/view/CreateView.php');


/**
* Kontroller för att skapa ett quiz.
*/
class CreateController{

	private $createSession;			// Instans av CreateSession();
	private $quizRepository;		// Instans av QuizRepository();
	private $createView;			// Instans av CreateView();



/**
  * Instansiserar alla nödvändiga modeller och vyer.
  */
	public function __construct(){
		$this->createSession = new \model\CreateSession();
		$this->createView = new \view\CreateView($this->createSession);
	}


/**
  * Funktion för att skapa en titel för quizet (sparas ner i en session).
  */
	public function doTitle(){


		// Redirects för olika URL-tillstånd.
			if ($this->createSession->createSessionIsset()) {
				\view\NavigationView::RedirectToCreateQuestions();
			}		
		

			$title = $this->createView->getTitle();

			if(isset($title)){
				$this->createSession->setTitleSession($title);
				\view\NavigationView::RedirectToCreateCreator();
			}

		// Utdata.
			return $this->createView->showCreateTitle();
	}


/**
  * Funktion för att skapa ett Quiz.
  */
	public function doCreate(){


		// Redirects för olika tillstånd.
			if(!$this->createSession->titleSessionIsset()){
				\view\NavigationView::RedirectHome();
			}

			if ($this->createSession->createSessionIsset()) {
				\view\NavigationView::RedirectToCreateQuestions();
			}

			if($this->createView->back()){
				\view\NavigationView::RedirectToCreateTitle();
			}



		// CREATE QUIZ.
			$quiz = $this->createView->getQuizData();
			if($quiz and $quiz->isValid()){
				$this->quizRepository = new \model\QuizRepository();
				$this->quizRepository->createQuiz($quiz);
				$this->createSession->setCreateSession($quiz->getQuizId());
				\view\NavigationView::RedirectToCreateQuestions();
			}


		// Utdata.
			return $this->createView->showCreateCreator();
		}
}