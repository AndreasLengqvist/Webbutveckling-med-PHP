<?php

namespace controller;

require_once("src/model/QuestionRepository.php");
require_once("src/model/AdressRepository.php");
require_once("src/model/QuizModel.php");
require_once('src/view/AdressView.php');


/**
* Kontroller för att skapa spelare/adresser.
*/
class AdressController{

	private $createModel;			// Instans av QuizModel();
	private $questionRepository;	// Instans av QuestionRepository();
	private $adressRepository;		// Instans av AdressRepository();
	private $adressView;			// Instans av AdressView();

	private $quizId;



/**
  * Instansierar alla nödvändiga modeller och vyer.
  */
	public function __construct(){
		$this->createModel = new \model\QuizModel();
		$this->questionRepository = new \model\QuestionRepository();
		$this->adressRepository = new \model\AdressRepository();
		$this->adressView = new \view\AdressView($this->createModel);

		$this->quizId = $this->createModel->getCreateSession();
	}


/**
  * REDIRECT-READ-CREATE-DELETE-funktion.
  *
  * @return String HTML
  */
	public function doPlayer(){


		// Redirects för olika URL-tillstånd.
			$questions = $this->questionRepository->getQuestionsById($this->quizId);
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
			$adressesObj = $this->adressRepository->getAdressesById($this->quizId);
			$adresses = $adressesObj->getAdresses();


		// CREATE.
			$adressToCreate = $this->adressView->getAdressToCreate();

			if($adressToCreate and $adressToCreate->isValid()){
				$this->adressRepository->addAdress($adressToCreate);
				\view\NavigationView::RedirectToAdressView();
			}


		// DELETE.
			if($this->adressView->deleteAdress()){
				$adressToDelete = $this->adressView->getAdressToDelete();
				$this->adressRepository->deleteAdress($adressToDelete);
				\view\NavigationView::RedirectToAdressView();
			}
			

		// UTDATA.
			return $this->adressView->show($adresses);
	}
}