<?php

namespace controller;

require_once('src/view/NavigationView.php');
require_once('TitleController.php');
require_once('QuestionController.php');
require_once('MailController.php');


class NavigationController{

	private $session;



	public function __construct(){
		$this->session = new \model\Session();
	}


	public function doNavigation(){

		try {

			if ($this->session->sessionIsset()) {

				switch (\view\NavigationView::getUrlAction($this->session)){

					case \view\NavigationView::$actionAddPlayers:
							$controller = new MailController($this->session);
							return $controller->doMail();
						break;

					default:
							$controller = new QuestionController($this->session);
							return $controller->doQuestion();
						break;
				}
			}

				switch (\view\NavigationView::getUrlAction($this->session)){

					case \view\NavigationView::$actionAddTitle:
							$controller = new TitleController($this->session);
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