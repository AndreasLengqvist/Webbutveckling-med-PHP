<?php

namespace controller;

require_once('src/view/QuestionView.php');
require_once("src/model/QuizRepository.php");


class QuestionController{

	private $session;



	public function __construct(\model\Session $session){
		$this->session = $session;
		$this->quizRepository = new \model\QuizRepository();
		$this->questionView = new \view\QuestionView($this->session->getSession(), $this->quizRepository);
	}


	public function doQuestion(){
		$quizId = $this->session->getSession();

		if($this->questionView->deleteQuestion()){
			$deleteQuestion = $this->questionView->getDeleteQuestion();

			$this->quizRepository->deleteQuestion($deleteQuestion);
		}

		if($this->questionView->submitQuestion()){
			try {

					$newQuestion = $this->questionView->getQuestionObj();
					$this->quizRepository->addQuestion($newQuestion);

			} catch (\Exception $e) {
				echo $e->getMessage();
			}
		}
		// Generar doQuestions utdata.
		return $this->questionView->show($this->quizRepository->getQuestionsById($quizId));
			
	}
}