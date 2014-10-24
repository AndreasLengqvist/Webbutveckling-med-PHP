<?php

namespace controller;

require_once('src/controller/CreateController.php');
require_once('src/controller/GameController.php');
require_once('src/view/NavigationView.php');

/**
* Kontroller för att navigera bland de andra kontrollrarna (MASTER).
* http://yuml.me/ebda40b3
*/
class NavigationController{



	public function doNavigation(){


		try {

			switch (\view\NavigationView::getUrlAction()) {


				// SKAPA QUIZ.
					case \view\NavigationView::$actionCreateTitle:
						$controller = new CreateController();
						return $controller->doTitle();
					break;

					case \view\NavigationView::$actionCreateCreator:
						$controller = new CreateController();
						return $controller->doCreate();
					break;

					case \view\NavigationView::$actionCreateQuestions:
						$controller = new CreateController();
						return $controller->doQuestion();
					break;

					case \view\NavigationView::$actionCreatePlayers:
						$controller = new CreateController();
						return $controller->doPlayer();
					break;

					case \view\NavigationView::$actionSend:
						$controller = new CreateController();
						return $controller->doMail();
					break;


				// SPELA QUIZ.
					case \view\NavigationView::$actionPlay:
						$controller = new GameController();
						return $controller->setupGame();
					break;

					case \view\NavigationView::$actionPlaying:
						$controller = new GameController();
						return $controller->playGame();
						break;


				// ERROR.
					case \view\NavigationView::$actionError:
						return \view\NavigationView::showError();
					break;


				// DEFAULT.
				default:
					return \view\NavigationView::showStart();
				break;
			}

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
}