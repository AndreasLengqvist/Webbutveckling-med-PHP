<?php

namespace controller;

require_once('src/view/QuestionView.php');
require_once("src/model/QuizRepository.php");


class QuestionController{

	private $session;



	public function __construct(\model\Session $session){
		$this->session = $session;
		$this->questionView = new \view\QuestionView($this->session);
		$this->quizRepository = new \model\QuizRepository();
	}


	public function doQuestion(){

		//$this->quizRepository->getQuestions($quizSession);

		if($this->questionView->newQuestion()){
			try {

					$newQuestion = $this->questionView->getQuestionObj($quizSession);
					$this->quizRepository->addQuestion($newQuestion);

			} catch (\Exception $e) {
				echo $e->getMessage();
			}
		}
		// Generar doQuestions utdata.
		return $this->questionView->show();
			
	}
}