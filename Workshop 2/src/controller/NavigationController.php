<?php

namespace controller;

require_once('src/controller/BoatController.php');
require_once('src/controller/MemberController.php');
require_once('src/controller/ListController.php');
require_once('src/view/NavigationView.php');



class NavigationController{



	public function doNavigation(){

	// Hanterar navigering av alla kontrollrar.
		try {

			switch (\view\NavigationView::getUrlAction()) {


				// Lista kompakt.
				case \view\NavigationView::actionShowCompact:
					$controller = new ListController();
					return $controller->showCompact();
				break;

				// Lista detaljerad.
				case \view\NavigationView::actionShowDetailed:
					$controller = new ListController();
					return $controller->showDetailed();
				break;

				// Visa medlem.
				case \view\NavigationView::actionShowMember:
					$controller = new MemberController();
					return $controller->showMember();
				break;
				
				// Skapa ny medlem.
				case \view\NavigationView::actionCreateMember:
					$controller = new MemberController();
					return $controller->createMember();
				break;

				// Ändra medlem.
				case \view\NavigationView::actionEditMember:
					$controller = new MemberController();
					return $controller->editMember();
				break;

				// Skapa båt.
				case \view\NavigationView::actionCreateBoat:
					$controller = new BoatControllr();
					return $controller->createBoat();
				break;

				// Editera båt.
				case \view\NavigationView::actionEditBoat:
					$controller = new BoatController();
					return $controller->editBoat();
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