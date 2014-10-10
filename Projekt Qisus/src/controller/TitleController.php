<?php

namespace controller;

require_once('src/view/TitleView.php');
require_once("src/model/QuizRepository.php");


class TitleController{

	private $session;



	public function __construct(\model\Session $session){
		$this->session = $session;
		$this->titleView = new \view\TitleView();
		$this->quizRepository = new \model\QuizRepository();
	}


	public function doTitle(){

	// Hanterar indata.
	try {
		
		$quiz = $this->titleView->getQuizData();

		// Om Quiz-objektet finns.
		if($quiz and $quiz->isValid()){

			// Hämta ett Quiz-objekt och lägg till en titel.
			$this->quizRepository->createQuiz($quiz);

			// Sätt sessionen och skicka användaren till frågeskaparen.
			$this->session->setSession($quiz->getQuizId());
			\view\NavigationView::RedirectToQuestionView();
		}
	} catch (\Exception $e) {
		echo $e;
		die();
	}

	// Generar utdata.
	return $this->titleView->show();
	}
}