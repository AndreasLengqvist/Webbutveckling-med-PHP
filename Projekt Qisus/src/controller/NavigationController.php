<?php

namespace controller;

require_once('src/view/NavigationView.php');
require_once('TitleController.php');
require_once('QuestionController.php');


class NavigationController{

	private $session;



	public function __construct(){
		$this->session = new \model\Session();
	}


	public function doNavigation(){

		try {

			switch (\view\NavigationView::getUrlAction($this->session)){

				case \view\NavigationView::$actionAddTitle:

					if ($this->session->sessionIsset()) {
						\view\NavigationView::RedirectToQuestionView();
						return null;
					}

						$controller = new TitleController($this->session);
						return $controller->doTitle();
					break;				

				case \view\NavigationView::$actionAddQuestions:

						$controller = new QuestionController($this->session);
						return $controller->doQuestion();
					break;
					
				default:

					if ($this->session->sessionIsset()) {
						\view\NavigationView::RedirectToQuestionView();
						return null;
					}
					
					return \view\NavigationView::showStart();
					break;
			}

		} catch (Exception $e) {
			echo"Fel";
		}
	}
}