<?php

namespace controller;

require_once('src/view/TitleView.php');
require_once("src/model/Quiz.php");
require_once("src/model/QuizRepository.php");
require_once("src/model/Session.php");
require_once("./common/Token.php");


class CreateController{

	private $token;
	private $titleview;



	public function __construct(){
		$this->titleView = new \view\TitleView();
		$this->quizRepository = new \model\QuizRepository();
	}


	public function doCreate(){

	if($this->titleView->submitTitle()){
		try {

			// Lägger till en titel.
			$newQuiz = $this->titleView->getTitle();
			$this->quizRepository->createQuiz($newQuiz);

			// Visar den nya vyn med titel och funktion för CRUD för frågor.
			$this->titleView->renderCRUD();

		} catch (\Exception $e) {
			echo $e->getMessage();
		}
	}

	// Generar utdata.
	return $this->titleView->show();
	}
}