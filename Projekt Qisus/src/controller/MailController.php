<?php

namespace controller;

require_once('src/view/MailView.php');
require_once("src/model/QuizRepository.php");


class MailController{

	private $session;



	public function __construct(\model\Session $session){
		$this->session = $session;
		$this->mailView = new \view\MailView();
		$this->quizRepository = new \model\QuizRepository();
	}


	public function doMail(){
		$quizId = $this->session->getSession();

	// Hanterar indata.
		try {

			$questions = $this->quizRepository->getQuestionsById($quizId);
			if(!$questions->getQuestions()){
				\view\NavigationView::RedirectToQuestionView();
			}

			if($this->mailView->backToQuestions()){
				\view\NavigationView::RedirectToQuestionView();
			}

		} catch (\Exception $e) {
			echo $e->getMessage();
		}

	// Generar doTitle utdata.
	return $this->mailView->show();
	}
}