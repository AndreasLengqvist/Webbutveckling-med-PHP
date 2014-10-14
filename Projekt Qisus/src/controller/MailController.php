<?php

namespace controller;

require_once('src/view/MailView.php');
require_once("src/model/QuizRepository.php");


class MailController{

	private $session;



	public function __construct(\model\CreateSession $session){
		$this->session = $session;
		$this->quizRepository = new \model\QuizRepository();
		$this->mailView = new \view\MailView($this->session->getCreateSession(), $this->quizRepository);
	}


	public function doMail(){
		$quizId = $this->session->getCreateSession();
		$adresses = $this->quizRepository->getAdressesById($quizId);

	// Hanterar indata.
		try {

			// Om användaren försöker komma vidare genom att ändra i URL:en.
			if(!$adresses->getAdresses()){
				\view\NavigationView::RedirectToPlayerView();
			}


			// Tillbaks till QuestionView.
			if($this->mailView->backToPlayers()){
				\view\NavigationView::RedirectToPlayerView();
			}


			// Skicka quizet!
			if($this->mailView->send()){
				foreach ($adresses->getAdresses() as $adress) {

					$to = $adress->getAdress();
					$title = $this->mailView->getTitle();
					$message = $this->mailView->renderMessage($adress->getAdressId());
					$header = $this->mailView->renderHeader();
					mail($to, $title, $message, $header);
					
				}
				$this->session->unSetCreateSession();
				return $this->mailView->showSent();
			}

		} catch (\Exception $e) {
			echo $e;
			die();
		}

	// Generar utdata.
		return $this->mailView->show();
	}
}