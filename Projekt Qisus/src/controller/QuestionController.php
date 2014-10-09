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


		// Restart
		if($this->questionView->restart()){
			$this->session->unSetSession();
			\view\NavigationView::RedirectHome();
		}

		try {

			// Lägger till ny fråga.
			if($this->questionView->submitQuestion()){

						$newQuestion = $this->questionView->getQuestionObj();
						$this->quizRepository->addQuestion($newQuestion);
			}

			// Ta bort fråga.
			if($this->questionView->deleteQuestion()){
				$deleteQuestion = $this->questionView->getDeleteQuestion();

				$this->quizRepository->deleteQuestion($deleteQuestion);
			}

			// Uppdaterar fråga.
			if($this->questionView->updateQuestion()){
				$updatedQuestion = $this->questionView->getUpdatedQuestion();

				$this->quizRepository->updateQuestion($updatedQuestion);
			}

		} catch (\Exception $e) {
			echo $e->getMessage();
		}
		// Generar doQuestions utdata.
		return $this->questionView->show($this->quizRepository->getQuestionsById($quizId));
			
	}
}