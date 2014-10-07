<?php

namespace controller;

require_once('src/view/NavigationView.php');
require_once('src/controller/CreateController.php');


class NavigationController{



	public function doNavigation(){

		

		try {

			switch (\view\NavigationView::getUrlAction()){
				case \view\NavigationView::$actionCreate:
						$controller = new CreateController();
						return $controller->doCreate();
					break;
				default:
					return \view\NavigationView::showStart();
					break;
			}

		} catch (Exception $e) {
			echo"Fel";
		}
	}
}