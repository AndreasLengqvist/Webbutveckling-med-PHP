<?php

namespace controller;

require_once('src/view/TitleView.php');
require_once("src/model/QuizRepository.php");


class TitleController{

	private $session;



	public function __construct(\model\Session $session){
		$this->session = $session;
		$questioncontroller = new QuestionController($this->session);
		$this->titleView = new \view\TitleView();
		$this->quizRepository = new \model\QuizRepository();
	}


	public function doTitle(){

	// Hanterar indata.

	// Om användaren tryckt på Klar med titel.
	if($this->titleView->submitTitle()){
		try {

				// Hämtar ett Quiz-objekt och lägger till en titel.
				$newQuiz = $this->titleView->getTitle();
				$this->quizRepository->createQuiz($newQuiz);

				// Skickar användaren till frågeskaparen.
				$this->session->setSession($newQuiz->getQuizId());
				\view\NavigationView::RedirectToQuestionView();

		} catch (\Exception $e) {
			echo $e->getMessage();
		}
	}
	// Generar doTitle utdata.
	return $this->titleView->show();
	}
}