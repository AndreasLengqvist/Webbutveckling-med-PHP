<?php

namespace controller;

require_once('src/view/CreateView.php');
require_once("src/model/Quiz.php");
require_once("src/model/Session.php");
require_once("./common/Token.php");


class CreateController{

	private $token;
	private $createview;


	public function __construct(){
		$this->token = new \Token();
		$this->createview = new\view\CreateView();
		$this->session = new\model\Session();
	}

	public function doCreate(){

	if($this->session->getUniqSession() === null){
		$this->session->setUniqSession();
	}

	if($this->createview->newQuestion()){		
		$this->createview->addQuestion();
	}

	if($this->createview->submitQuestion()){
		try {

			$question = new \model\Question($this->createview->getQuestion(), $this->createview->getAnswer());

		} catch (Exception $e) {
			echo"$e";
		}
	}

	// Generar utdata.
	return $this->createview->show();
	}
}