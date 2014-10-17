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


				// Lista kompakt.
				case \view\NavigationView::$actionShowCompact:
					return \view\NavigationView::showStart();
				break;

				// Lista detaljerad.
				case \view\NavigationView::$actionShowDetailed:
					$controller = new GameController();
					return $controller->setupGame();
				break;


				// Visa medlem.
				case \view\NavigationView::$actionShowMember
					$controller = new MemberController();
					return $controller->showMember();
				break;
				
				// Skapa ny medlem.
				case \view\NavigationView::$actionCreateMember
					$controller = new MemberController();
					return $controller->doMember();
				break;

				// Ändra medlem.
				case \view\NavigationView::$actionEditMember:
					$controller = new MemberController();
					return $controller->doMember();
				break;

				// Skapa båt.
				case \view\NavigationView::$actionCreateBoat:
					$controller = new BoatControllr();
					return $controller->doQuestion();
				break;

				// Editera båt.
				case \view\NavigationView::$actionEditBoat:
					$controller = new BoatController();
					return $controller->doPlayer();
				break;


				default:
					return \view\NavigationView::actionShowCompact();
				break;
			}

		} catch (Exception $e) {
			echo $e;
			die();
		}
	}
}