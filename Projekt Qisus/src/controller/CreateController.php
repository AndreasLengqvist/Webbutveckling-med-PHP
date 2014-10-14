<?php

namespace controller;

require_once("src/model/QuizRepository.php");
require_once('src/view/CreateView.php');


class CreateController{

	private $session;



	public function __construct(\model\CreateSession $createSession){
		$this->createSession = $createSession;
		$this->createView = new \view\CreateView($this->createSession);
		$this->quizRepository = new \model\QuizRepository();
	}


	public function doTitle(){

		// Hanterar indata.		
				$title = $this->createView->getTitle();

				// Om titeln är satt.
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

				if($this->createView->back()){
					\view\NavigationView::RedirectToCreateTitle();
				}

				$quiz = $this->createView->getQuizData($this->createSession->getTitleSession());

				// Om Quiz-objektet finns.
				if($quiz and $quiz->isValid()){

					// Hämta ett Quiz-objekt och skapa quizet i databasen.
					$this->quizRepository->createQuiz($quiz);

					// Sätt sessionen och skicka användaren till frågeskaparen.
					$this->createSession->setCreateSession($quiz->getQuizId());
					$this->createSession->unSetTitleSession();
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