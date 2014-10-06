<?php

namespace controller;

require_once('src/view/NavigationView.php');
require_once('src/controller/CreateController.php');


class NavigationController{


	public function __construct(){
		$this->navigationview = new\view\NavigationView();
		$this->createcontroller = new CreateController();
	}

	public function doNavigation(){

		if($this->navigationview->createPressed()){
			return $this->createcontroller->doCreate();

		}
		else{
			return $this->navigationview->show();
		}
	}
}