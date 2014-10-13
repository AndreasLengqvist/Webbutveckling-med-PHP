<?php

namespace controller;

require_once("src/model/QuizRepository.php");
require_once("src/model/Session.php");
require_once("src/model/PlaySession.php");
require_once('src/view/NavigationView.php');
require_once('TitleController.php');
require_once('QuestionController.php');
require_once('PlayerController.php');
require_once('MailController.php');
require_once('GameController.php');


class NavigationController{

	private $createSession;
	private $playSession;



	public function __construct(){
		$this->quizRepository = new \model\QuizRepository();
		$this->createSession = new \model\Session();
		$this->playSession = new \model\PlaySession();
	}


	public function doNavigation(){

	// Hanterar navigering av alla kontrollrar.
		try {

			// Om en CreateSession är satt.
			if ($this->createSession->sessionIsset()) {

				switch (\view\NavigationView::getUrlAction()){

					case \view\NavigationView::$actionAddPlayers:
							$controller = new PlayerController($this->createSession);
							return $controller->doPlayer();
						break;

					case \view\NavigationView::$actionMailQuiz:
							$controller = new MailController($this->createSession);
							return $controller->doMail();
						break;

					default:
							$controller = new QuestionController($this->createSession);
							return $controller->doQuestion();
						break;
				}
			}

				switch (\view\NavigationView::getUrlAction()){


					case \view\NavigationView::$actionPlay:
							$controller = new GameController($this->playSession);

							// Om PlaySessionen är satt.
							if ($this->playSession->playSessionsIsset()) {
								return $controller->playGame();
							}
							return $controller->setupGame();
						break;


					case \view\NavigationView::$actionAddTitle:
							$controller = new TitleController($this->createSession);
							return $controller->doTitle();
						break;

					default:

						return \view\NavigationView::showStart();
						break;
				}

		} catch (Exception $e) {
			echo $e;
			die();
		}
	}
}