<?php

namespace controller;

require_once("src/model/QuizRepository.php");
require_once("src/model/CreateSession.php");
require_once("src/model/PlaySession.php");
require_once('src/view/NavigationView.php');
require_once('CreateController.php');
require_once('QuestionController.php');
require_once('PlayerController.php');
require_once('MailController.php');
require_once('GameController.php');


class NavigationController{

	private $createSession;
	private $playSession;


	public function __construct(){
		$this->quizRepository = new \model\QuizRepository();
		$this->createSession = new \model\CreateSession();
		$this->playSession = new \model\PlaySession();
	}


	public function doNavigation(){

	// Hanterar navigering av alla kontrollrar.
		try {

			switch (\view\NavigationView::getUrlAction()) {

				// SKAPA QUIZ
				case \view\NavigationView::$actionCreate:
					return \view\NavigationView::showStart();
					
						case \view\NavigationView::$actionCreateTitle:
							if ($this->createSession->createSessionIsset()) {
								\view\NavigationView::RedirectToCreateQuestions();
							}
							$controller = new CreateController($this->createSession);
							return $controller->doTitle();
						break;

						case \view\NavigationView::$actionCreateCreator:
							if(!$this->createSession->titleSessionIsset()){
								\view\NavigationView::RedirectHome();
							}
							if ($this->createSession->createSessionIsset()) {
								\view\NavigationView::RedirectToCreateQuestions();
							}
							$controller = new CreateController($this->createSession);
							return $controller->doCreator();
						break;

						case \view\NavigationView::$actionCreateQuestions:
							if (!$this->createSession->createSessionIsset()) {
								\view\NavigationView::RedirectHome();
							}
							$controller = new QuestionController($this->createSession);
							return $controller->doQuestion();
						break;

						case \view\NavigationView::$actionCreatePlayers:
							$controller = new PlayerController($this->createSession);
							return $controller->doPlayer();
						break;

						case \view\NavigationView::$actionSend:
							$controller = new MailController($this->createSession);
							return $controller->doMail();
						break;

				// SPELA QUIZ
				case \view\NavigationView::$actionPlay:
					$controller = new GameController($this->playSession);
					// Om PlaySessionen är satt.
					if ($this->playSession->playSessionsIsset()) {
						return $controller->playGame();
					}
					return $controller->setupGame();
					break;

				default:
					return \view\NavigationView::showStart();
					break;
			}
			/*// Om en CreateSession är satt.
			if ($this->createSession->createSessionIsset()) {

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
							$controller = new CreateController($this->createSession);
							return $controller->doTitle();
						break;

					case \view\NavigationView::$actionAddCreator:
							return $controller->doCreator();
						break;

					default:

						return \view\NavigationView::showStart();
						break;
				}*/

		} catch (Exception $e) {
			echo $e;
			die();
		}
	}
}