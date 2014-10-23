<?php

namespace controller;

require_once("src/model/QuestionRepository.php");
require_once("src/model/AdressRepository.php");
require_once("src/model/QuizModel.php");
require_once('src/view/CreateView.php');
require_once('src/view/QuestionView.php');
require_once('src/view/AdressView.php');
require_once('src/view/MailView.php');


/**
* Kontroller för att skapa ett quiz.
*/
class CreateController{

	private $createModel;			// Instans av QuizModel();
	private $createView;			// Instans av CreateView();
	private $questionView;			// Instans av CreateView();
	private $adressView;			// Instans av CreateView();
	private $mailView;				// Instans av CreateView();

	private $quizId;

/**
  * Instansierar alla nödvändiga modeller och vyer.
  */
	public function __construct(){
		$this->createModel = new \model\QuizModel();

		$this->createView = new \view\CreateView($this->createModel);
		$this->questionView = new \view\QuestionView($this->createModel);
		$this->adressView = new \view\AdressView($this->createModel);
		$this->mailView = new \view\MailView($this->createModel);
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
  * Funktion för att skapa Quiz.
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



/**
  * Funktion för att skapa frågor.
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
			$questionsObj = $this->createModel->getQuestionsById($this->createModel->getCreateSession());
			$questions = $questionsObj->getQuestions();


		// CREATE.
			$questionToCreate = $this->questionView->getQuestionToCreate();
			
			if($questionToCreate and $questionToCreate->isValid()){
				$this->createModel->addQuestion($questionToCreate);
				\view\NavigationView::RedirectToQuestionView();
			}


		// UPDATE.
			$questionToUpdate = $this->questionView->getQuestionToUpdate();

			if($questionToUpdate and $questionToUpdate->isValid()){
				$this->createModel->updateQuestion($questionToUpdate);
				\view\NavigationView::RedirectToQuestionView();
			}


		// DELETE.
			if($this->questionView->deleteQuestion()){
				$questionToDelete = $this->questionView->getQuestionToDelete();
				$this->createModel->deleteQuestion($questionToDelete);
				\view\NavigationView::RedirectToQuestionView();
			}
			

		// UTDATA.
			return $this->questionView->show($questions);
	}



/**
  * Funktion för att skapa spelare.
  *
  * @return String HTML
  */
	public function doPlayer(){
			$quizId = $this->createModel->getCreateSession();


		// Redirects för olika URL-tillstånd.
			$questions = $this->createModel->getQuestionsById($quizId);
			if(!$questions->getQuestions()){
				\view\NavigationView::RedirectToQuestionView();
			}

			if($this->adressView->backToQuestions()){
				\view\NavigationView::RedirectToQuestionView();
			}

			if($this->adressView->finished()){
				\view\NavigationView::RedirectToSend();
			}


		// READ.
			$adressesObj = $this->createModel->getAdressesById($quizId);
			$adresses = $adressesObj->getAdresses();


		// CREATE.
			$adressToCreate = $this->adressView->getAdressToCreate();

			if($adressToCreate and $adressToCreate->isValid()){
				$this->createModel->addAdress($adressToCreate);
				\view\NavigationView::RedirectToAdressView();
			}


		// DELETE.
			if($this->adressView->deleteAdress()){
				$adressToDelete = $this->adressView->getAdressToDelete();
				$this->createModel->deleteAdress($adressToDelete);
				\view\NavigationView::RedirectToAdressView();
			}
			

		// UTDATA.
			return $this->adressView->show($adresses);
	}



/**
  * Funktion för att skicka iväg quizet.
  *
  * @return String HTML
  */
	public function doMail(){
			$quizId = $this->createModel->getCreateSession();
			$adressesObj = $this->createModel->getAdressesById($quizId);
			$adresses = $adressesObj->getAdresses();

		// Redirects för olika URL-tillstånd.
			if(!$adresses){
				\view\NavigationView::RedirectToAdressView();
			}

			if($this->mailView->backToPlayers()){
				\view\NavigationView::RedirectToAdressView();
			}


		// SEND.
			if($this->mailView->send()){
				foreach ($adresses as $adress) {

					try {

						$to = $adress->getAdress();
						$title = $this->createModel->getTitleSession();
						$message = $this->mailView->renderMessage($adress->getAdressId(), $title);
						$header = $this->mailView->renderHeader();

						mail($to, $title, $message, $header);

					} catch (\Exception $e) {

						error_log($e->getMessage() . "\n", 3, \Config::ERROR_LOG);

						if (\Config::DEBUG) {
							echo $e;
						} else{
							\view\NavigationView::RedirectToErrorPage();
							die();
						}
					}
				}
				
				$this->createModel->unSetCreateSession();
				return $this->mailView->showSent();
			}


		// UTDATA.
			return $this->mailView->show();
	}
}