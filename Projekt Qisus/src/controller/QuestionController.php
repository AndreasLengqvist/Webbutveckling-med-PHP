<?php

namespace controller;

require_once("src/model/QuestionRepository.php");
require_once("src/model/QuizModel.php");
require_once('src/view/QuestionView.php');


/**
* Kontroller för skapa frågor i ett quiz.
*/
class QuestionController{

	private $createModel;			// Instans av QuizModel();
	private $questionRepository;	// Instans av QuestionRepository();
	private $questionView;			// Instans av QuestionView();


/**
  * Instansiserar alla nödvändiga modeller och vyer.
  * Hämtar även ut nödvändig data för att minska anrop i senare funktioner.
  */
	public function __construct(){
		$this->createModel = new \model\QuizModel();
		$this->questionRepository = new \model\QuestionRepository();
		$this->questionView = new \view\QuestionView($this->createModel);
	}


/**
  * REDIRECT-RESTART-CRUD-funktion.
  *
  * @return String HTML
  */
	public function doQuestion(){


		// Redirects för olika URL-tillstånd.
			if (!$this->createModel->createSessionIsset()) {
				\view\NavigationView::RedirectHome();
			}

			if($this->questionView->finished()){
				\view\NavigationView::RedirectToAdressView();
			}


		// RESTART.
			if($this->questionView->restart()){
				$this->createModel->resetQuiz();
				\view\NavigationView::RedirectHome();
			}


		// READ.
			$questionsObj = $this->questionRepository->getQuestionsById($this->createModel->getCreateSession());
			$questions = $questionsObj->getQuestions();


		// CREATE.
			$questionToCreate = $this->questionView->getQuestionToCreate();
			
			if($questionToCreate and $questionToCreate->isValid()){
				$this->questionRepository->addQuestion($questionToCreate);
				\view\NavigationView::RedirectToQuestionView();
			}


		// UPDATE.
			$questionToUpdate = $this->questionView->getQuestionToUpdate();

			if($questionToUpdate and $questionToUpdate->isValid()){
				$this->questionRepository->updateQuestion($questionToUpdate);
				\view\NavigationView::RedirectToQuestionView();
			}


		// DELETE.
			if($this->questionView->deleteQuestion()){
				$questionToDelete = $this->questionView->getQuestionToDelete();
				$this->questionRepository->deleteQuestion($questionToDelete);
				\view\NavigationView::RedirectToQuestionView();
			}
			

		// UTDATA.
			return $this->questionView->show($questions);
	}
}