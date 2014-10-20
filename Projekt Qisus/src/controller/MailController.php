<?php

namespace controller;

require_once("src/model/AdressRepository.php");
require_once("src/model/QuizModel.php");
require_once('src/view/MailView.php');


/**
* Kontroller för att skicka ett quiz.
*/
class MailController{

	private $createModel;			// Instans av QuizModel();
	private $adressRepository;		// Instans av AdressRepository();
	private $mailView;				// Instans av MailView();

	private $quizId;



/**
  * Instansiserar alla nödvändiga modeller och vyer.
  * Hämtar även ut nödvändig data för att minska anrop i senare funktioner.
  */
	public function __construct(){
		$this->createModel = new \model\QuizModel();
		$this->adressRepository = new \model\AdressRepository();
		
		$this->quizId = $this->createModel->getCreateSession();

		$this->mailView = new \view\MailView($this->createModel, $this->adressRepository, $this->quizId);
	}


/**
  * REDIRECT-SEND-funktion.
  *
  * @return String HTML
  */
	public function doMail(){

			$adressesObj = $this->adressRepository->getAdressesById($this->quizId);
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