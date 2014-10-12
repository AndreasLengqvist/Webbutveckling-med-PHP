<?php

namespace controller;

require_once('src/view/MailView.php');
require_once("src/model/QuizRepository.php");


class MailController{

	private $session;



	public function __construct(\model\Session $session){
		$this->session = $session;
		$this->quizRepository = new \model\QuizRepository();
		$this->mailView = new \view\MailView($this->session->getSession(), $this->quizRepository);
	}


	public function doMail(){
		$quizId = $this->session->getSession();
		$adresses = $this->quizRepository->getAdressesById($quizId);

	// Hanterar indata.
		try {

			// Ful-lösning för att användaren inte ska kunna ändra i URL:en.
			if(!$adresses->getAdresses()){
				\view\NavigationView::RedirectToPlayerView();
			}


			// Tillbaka till QuestionView.
			if($this->mailView->backToPlayers()){
				\view\NavigationView::RedirectToPlayerView();
			}

			if($this->mailView->send()){
				foreach ($adresses->getAdresses() as $adress) {
					$message = $this->mailView->renderMessage($quizId, $adress->getAdressId(), $this->mailView->getMessage());
					mail($adress->getAdress(), $this->quizRepository->getTitleById($quizId), $message);
					echo"Skickat!";
				}
			}

		} catch (\Exception $e) {
			echo $e;
			die();
		}

	// Generar utdata.
	return $this->mailView->show();
	}
}