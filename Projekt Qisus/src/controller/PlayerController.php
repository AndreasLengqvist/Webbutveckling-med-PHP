<?php

namespace controller;

require_once('src/view/PlayerView.php');
require_once("src/model/QuizRepository.php");


class PlayerController{

	private $session;



	public function __construct(\model\Session $session){
		$this->session = $session;
		$this->quizRepository = new \model\QuizRepository();
		$this->playerView = new \view\PlayerView($this->session->getSession(), $this->quizRepository);
	}


	public function doPlayer(){
		$quizId = $this->session->getSession();

	// Hanterar indata.
		try {

			// Ful-lösning för att användaren inte ska kunna ändra i URL:en.
			$questions = $this->quizRepository->getQuestionsById($quizId);
			if(!$questions->getQuestions()){
				\view\NavigationView::RedirectToQuestionView();
			}


			// Tillbaka till QuestionView.
			if($this->playerView->backToQuestions()){
				\view\NavigationView::RedirectToQuestionView();
			}


			// Fortsätter till SendView.
			if($this->playerView->finished()){
				\view\NavigationView::RedirectToMailView();
			}


			// LÄGGA TILL ADRESS - Om Adress-objektet finns för att lägga till ny fråga.
			$adress = $this->playerView->getAdressData();
			if($adress and $adress->isValid()){
				$this->quizRepository->addAdress($adress);
			}


				// TA BORT ADRESS.
				if($this->playerView->deleteAdress()){
					$adress = $this->playerView->getAdressToDelete();
					$this->quizRepository->deleteAdress($adress);
				}

		} catch (\Exception $e) {
			echo $e;
			die();
		}

	// Generar utdata.
	return $this->playerView->show($this->quizRepository->getAdressesById($quizId));
	}
}