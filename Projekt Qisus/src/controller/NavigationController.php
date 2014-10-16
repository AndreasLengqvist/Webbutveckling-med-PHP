<?php

namespace controller;

require_once('src/controller/CreateController.php');
require_once('src/controller/QuestionController.php');
require_once('src/controller/PlayerController.php');
require_once('src/controller/MailController.php');
require_once('src/controller/GameController.php');
require_once('src/view/NavigationView.php');


class NavigationController{



	public function doNavigation(){

	// Hanterar navigering av alla kontrollrar.
		try {

			switch (\view\NavigationView::getUrlAction()) {


				// SKAPA QUIZ
				case \view\NavigationView::$actionCreate:
					return \view\NavigationView::showStart();
				break;

						case \view\NavigationView::$actionCreateTitle:
							$controller = new CreateController();
							return $controller->doTitle();
						break;

						case \view\NavigationView::$actionCreateCreator:
							$controller = new CreateController();
							return $controller->doCreator();
						break;

						case \view\NavigationView::$actionCreateQuestions:
							$controller = new QuestionController();
							return $controller->doQuestion();
						break;

						case \view\NavigationView::$actionCreatePlayers:
							$controller = new PlayerController();
							return $controller->doPlayer();
						break;

						case \view\NavigationView::$actionSend:
							$controller = new MailController();
							return $controller->doMail();
						break;


				// SPELA QUIZ
				case \view\NavigationView::$actionPlay:
					$controller = new GameController();
					return $controller->setupGame();
				break;

					case \view\NavigationView::$actionPlaying:
						$controller = new GameController();
						return $controller->playGame();
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