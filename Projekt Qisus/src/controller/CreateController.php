<?php

namespace controller;

require_once("src/model/QuizModel.php");
require_once('src/view/CreateView.php');


/**
* Kontroller för att skapa ett quiz.
*/
class CreateController{

	private $createModel;			// Instans av QuizModel();
	private $createView;			// Instans av CreateView();



/**
  * Instansierar alla nödvändiga modeller och vyer.
  */
	public function __construct(){
		$this->createModel = new \model\QuizModel();
		$this->createView = new \view\CreateView($this->createModel);
	}


/**
  * Funktion för att skapa en titel för quizet (ID:t sparas ner i en session).
  *
  * @return String HTML
  */
	public function doTitle(){


		// Redirects för olika URL-tillstånd.
			if ($this->createModel->createSessionIsset()) {
				\view\NavigationView::RedirectToQuestionView();
			}		
		

			$title = $this->createView->getTitle();

			if(isset($title)){
				$this->createModel->setTitleSession($title);
				\view\NavigationView::RedirectToCreateCreator();
			}

		// Utdata.
			return $this->createView->showCreateTitle();
	}


/**
  * REDIRECT-CREATE-funktion.
  */
	public function doCreate(){


		// Redirects för olika tillstånd.
			if(!$this->createModel->titleSessionIsset()){
				\view\NavigationView::RedirectHome();
			}

			if ($this->createModel->createSessionIsset()) {
				\view\NavigationView::RedirectToQuestionView();
			}

			if($this->createView->back()){
				\view\NavigationView::RedirectToCreateTitle();
			}


		// CREATE.
			$quiz = $this->createView->getQuizToCreate();

			if($quiz and $quiz->isValid()){
				$this->createModel->createQuiz($quiz);
				\view\NavigationView::RedirectToQuestionView();
			}


		// UTDATA.
			return $this->createView->showCreateCreator();
		}
}