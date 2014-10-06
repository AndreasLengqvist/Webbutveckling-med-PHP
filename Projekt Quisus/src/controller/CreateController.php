<?php

namespace controller;

require_once('src/view/CreateView.php');
require_once("src/model/Quiz.php");


class CreateController{


	public function __construct(){
		$this->createview = new\view\CreateView();
	}

	public function doCreate(){

	$this->createview->addQuestion();

	if($this->createview->newQuestion()){
		$this->createview->addQuestion();
	}
	if($this->createview->submitQuestions()){
		try {

			$quiz = new \model\Quiz($this->createview->getQuestion(), $this->createview->getAnswer());

		} catch (Exception $e) {
			echo"$e";
		}
	}

	// Generar utdata.
	return $this->createview->show();
	}
}