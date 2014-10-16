<?php

namespace controller;

require_once("src/model/QuizRepository.php");
require_once("src/model/CreateSession.php");
require_once('src/view/MailView.php');


class MailController{

	private $createSession;
	private $quizRepository;
	private $mailView;



	public function __construct(){
		$this->createSession = new \model\CreateSession();
		$this->quizRepository = new \model\QuizRepository();
		$this->mailView = new \view\MailView($this->createSession, $this->quizRepository);
	}


	public function doMail(){

	// Hanterar indata.
		try {

			$quizId = $this->createSession->getCreateSession();
			$adresses = $this->quizRepository->getAdressesById($quizId);

			// Redirects för olika URL-tillstånd.
				if(!$adresses->getAdresses()){
					\view\NavigationView::RedirectToPlayerView();
				}

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
					$this->createSession->unSetCreateSession();
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