<?php

namespace controller;

require_once("src/model/QuizRepository.php");
require_once("src/model/CreateSession.php");
require_once('src/view/AdressView.php');


class AdressController{

	private $createSession;
	private $quizRepository;
	private $adressView;



	public function __construct(){
		$this->createSession = new \model\CreateSession();
		$this->quizRepository = new \model\QuizRepository();
		$this->adressView = new \view\AdressView($this->createSession, $this->quizRepository);
	}


	public function doPlayer(){

	// Hanterar indata.
		try {

			// Redirects för olika URL-tillstånd.
				$questions = $this->quizRepository->getQuestionsById($this->createSession->getCreateSession());
				if(!$questions->getQuestions()){
					\view\NavigationView::RedirectToCreateQuestions();
				}

				if($this->adressView->backToQuestions()){
					\view\NavigationView::RedirectToCreateQuestions();
				}

				if($this->adressView->finished()){
					\view\NavigationView::RedirectToSend();
				}


			// LÄGG TILL ADRESS - Om Adress-objektet är validerat och satt.
			$adress = $this->adressView->getAdressData();
			if($adress and $adress->isValid()){
				$this->quizRepository->addAdress($adress);
			}


				// TA BORT ADRESS.
				if($this->adressView->deleteAdress()){
					$adress = $this->adressView->getAdressToDelete();
					$this->quizRepository->deleteAdress($adress);
				}

		} catch (\Exception $e) {
			echo $e;
			die();
		}

	// Generar utdata.
		return $this->adressView->show();
	}
}