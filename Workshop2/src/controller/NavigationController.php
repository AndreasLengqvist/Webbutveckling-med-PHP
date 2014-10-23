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