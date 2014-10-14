<?php

namespace controller;

require_once('src/view/PlayerView.php');
require_once("src/model/QuizRepository.php");


class PlayerController{

	private $session;



	public function __construct(\model\CreateSession $createSession){
		$this->createSession = $createSession;
		$this->quizRepository = new \model\QuizRepository();
		$this->playerView = new \view\PlayerView($this->createSession->getCreateSession(), $this->quizRepository);
	}


	public function doPlayer(){
		$quizId = $this->createSession->getCreateSession();
		$questions = $this->quizRepository->getQuestionsById($quizId);

	// Hanterar indata.
		try {

			// Om användaren försöker komma vidare genom att ändra i URL:en.
			if(!$questions->getQuestions()){
				\view\NavigationView::RedirectToQuestionView();
			}


			// Tillbaks till QuestionView.
			if($this->playerView->backToQuestions()){
				\view\NavigationView::RedirectToQuestionView();
			}


			// Fortsätt till SendView.
			if($this->playerView->finished()){
				\view\NavigationView::RedirectToMailView();
			}


			// LÄGG TILL ADRESS - Om Adress-objektet är validerat och satt.
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