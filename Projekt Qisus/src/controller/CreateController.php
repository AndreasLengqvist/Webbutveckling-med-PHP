<?php

namespace controller;

require_once("src/model/QuizRepository.php");
require_once("src/model/CreateSession.php");
require_once('src/view/CreateView.php');


class CreateController{

	private $createSession;
	private $createView;



	public function __construct(){
		$this->createSession = new \model\CreateSession();
		$this->createView = new \view\CreateView($this->createSession);
	}


	public function doTitle(){

		// Hanterar indata.	
				
				// Redirects för olika URL-tillstånd.
					if ($this->createSession->createSessionIsset()) {
						\view\NavigationView::RedirectToCreateQuestions();
					}		
				

				$title = $this->createView->getTitle();

				if(isset($title)){
					$this->createSession->setTitleSession($title);
					\view\NavigationView::RedirectToCreateCreator();
				}

		// Generar utdata.
			return $this->createView->showCreateTitle();
		}


	public function doCreator(){

		// Hanterar indata.
			try {

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


				$quiz = $this->createView->getQuizData();

				// Lägger till Quizet i databasen.
					if($quiz and $quiz->isValid()){
						$this->quizRepository = new \model\QuizRepository();
						$this->quizRepository->createQuiz($quiz);
						$this->createSession->setCreateSession($quiz->getQuizId());
						\view\NavigationView::RedirectToCreateQuestions();
					}
				
			} catch (\Exception $e) {
				echo $e;
				die();
			}

		// Generar utdata.
			return $this->createView->showCreateCreator();
		}
}