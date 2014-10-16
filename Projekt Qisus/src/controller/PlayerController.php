<?php

namespace controller;

require_once("src/model/QuizRepository.php");
require_once("src/model/CreateSession.php");
require_once('src/view/PlayerView.php');


class PlayerController{

	private $createSession;
	private $quizRepository;
	private $playerView;



	public function __construct(){
		$this->createSession = new \model\CreateSession();
		$this->quizRepository = new \model\QuizRepository();
		$this->playerView = new \view\PlayerView($this->createSession, $this->quizRepository);
	}


	public function doPlayer(){

	// Hanterar indata.
		try {

			// Redirects för olika URL-tillstånd.
				$questions = $this->quizRepository->getQuestionsById($this->createSession->getCreateSession());
				if(!$questions->getQuestions()){
					\view\NavigationView::RedirectToCreateQuestions();
				}

				if($this->playerView->backToQuestions()){
					\view\NavigationView::RedirectToCreateQuestions();
				}

				if($this->playerView->finished()){
					\view\NavigationView::RedirectToSend();
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
		return $this->playerView->show();
	}
}